<?php

declare(strict_types=1);


namespace Site;


use Lustra\Config;
use Lustra\Web\App;
use Lustra\Web\Router\RouteNotFoundException;

use DebugBar\DebugBar;
use DebugBar\DataCollector\ConfigCollector;
use DebugBar\DataCollector\PhpInfoCollector;
use DebugBar\DataCollector\RequestDataCollector;

use Throwable;


class Site extends App {

	public function setup() : void {
		$this->setupPage( $this->container->get( Page::class ) );
	}


	public function setupPage( Page $page ) : void {
		$page->addMeta( [ 'charset' => 'UTF-8' ] );
		$page->addMeta( [ 'name' => 'viewport', 'content' => 'width=device-width, initial-scale=1' ] );
		$page->addCss( 'https://cdn.jsdelivr.net/gh/kimeiga/bahunya/dist/bahunya.min.css' );
	}


	public function initializeTemplateData() : array {
		return [
			'config'   => $this->container->get( Config::class ),
			'router'   => $this->router,
			'page'     => $this->container->get( Page::class ),
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
			400 => 'Bad Request',
			401 => 'Unauthorized',
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

		$this->render( [ "error-{$http_status}", 'error' ], $tpl_data );

		exit;
	}


	public function render(
		string|array $path,
		array &$data = null
	) : void {

		$config = $this->container->get( Config::class );

		if ( $config->get( 'debug' ) ) {
			$this->addDebugbarInfo(
				$config,
				$this->container->get( Page::class ),
				$this->container->get( DebugBar::class ),
			);
		}

		parent::render( $path, $data );
	}


	private function addDebugbarInfo(
		Config $config,
		Page $page,
		DebugBar $debugbar,
	) : void {

		$debugbar->addCollector(
			new ConfigCollector(
				$config->getDebugInfo(),
				'config'
			)
		);

		$debugbar->addCollector(
			new ConfigCollector(
				$this->container->getDebugInfo(),
				'container'
			)
		);

		$debugbar->addCollector(
			new ConfigCollector(
				$this->route,
				'route'
			)
		);

		$debugbar->addCollector(
			new ConfigCollector(
				$this->router->getDebugInfo(),
				'router'
			)
		);

		$debugbar->addCollector(
			new RequestDataCollector()
		);

		$debugbar->addCollector(
			new PhpInfoCollector()
		);

		$renderer = $debugbar->getJavascriptRenderer();
		$renderer->setOptions( [ 'base_url' => 'debugbar' ] );

		$page->addHeadContent( $renderer->renderHead() );
		$page->addBodyContent( $renderer->render() );
	}

}
