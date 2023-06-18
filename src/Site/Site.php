<?php

declare(strict_types=1);


namespace Site;


use Lustra\Web\App;
use Lustra\Web\Router\RouteNotFoundException;

use Throwable;


class Site extends App {

	public function initializeTemplateData() : array {
		return [
			'router'   => $this->router,
			'config'   => $this->container->get( 'config' ),
			'page_tpl' => $this->getTemplatePath( $this->route['name'] ),
		];
	}


	public function handleError( Throwable $error ) : void {
		error_log(
			sprintf(
				'%s: %s in %s (%s)',
				get_class( $error ),
				$error->getMessage(),
				$error->getFile(),
				$error->getLine()
			)
		);

		$http_status   = 500;
		$error_message = 'An internal error has occurred.';

		if ( $error instanceof RouteNotFoundException ) {
			$http_status   = 404;
			$error_message = $error->getMessage();
		}

		$this->displayErrorPage( $http_status, $error_message );
	}


	public function displayErrorPage(
		int $http_status,
		string $error_message
	) : void {

		$messages = [
			403 => 'Forbidden',
			404 => 'Not Found',
			500 => 'Internal Server Error',
		];

		if ( ! isset( $messages[ $http_status ] ) ) {
			$http_status = 500;
		}

		$message = $messages[ $http_status ];

		$tpl_data = [
			'error_message' => $error_message,
			'http_status'   => $http_status,
			'message'       => $message,
		];

		header(
			sprintf( 'HTTP/1.1 %s %s', $http_status, $message ),
			true
		);

		ob_clean();

		$this->render( 'error', $tpl_data );

		exit;
	}

}
