<?php

declare(strict_types=1);


namespace Site;


class Page {

	private array $components = [
		'meta'        => [],
		'link'        => [],
		'script_head' => [],
		'script_body' => [],
	];

	private array $extra_content = [
		'head' => [],
		'body' => [],
	];


	public function buildHead() : string {
		return
			$this->buildMetaTags() .
			$this->buildLinkTags() .
			$this->buildScriptTags( 'head' ) .
			$this->buildExtraContent( 'head' );
	}


	public function buildBody() : string {
		return
			$this->buildScriptTags( 'body' ) .
			$this->buildExtraContent( 'body' );
	}


	public function addHeadContent( string|callable $content ) : void {
		$this->extra_content['head'][] = $content;
	}


	public function addBodyContent( string|callable $content ) : void {
		$this->extra_content['body'][] = $content;
	}


	public function buildExtraContent( string $location ) : string {
		$content = '';

		foreach ( $this->extra_content[ $location ] as $v ) {
			$content .= is_string( $v ) ? $v : $v();
		}

		return $content;
	}


	public function get( string $k ) : array {
		return $this->components[ $k ];
	}


	private function addToComponent(
		string $component,
		array $attrs,
		bool $prepend = false
	) : void {

		if ( $prepend ) {
			array_unshift( $this->components[ $component ], $attrs );
		} else {
			array_push( $this->components[ $component ], $attrs );
		}
	}


	public function addMeta( array $attrs, bool $prepend = false ) : void {
		$this->addToComponent( 'meta', $attrs, $prepend );
	}


	public function addLink( array $attrs, bool $prepend = false ) : void {
		$this->addToComponent( 'link', $attrs, $prepend );
	}


	public function addScript(
		array $attrs,
		string $where = 'body',
		bool $prepend = false
	) : void {

		$this->addToComponent( "script_{$where}", $attrs, $prepend );
	}


	// ----------------------------------------


	public function addCss(
		string $href,
		array $attrs = [],
		bool $prepend = false
	) : void {

		$defaults = [
			'rel'  => 'stylesheet',
			'href' => $href,
		];

		$attrs = array_merge( $defaults, $attrs );

		$this->addLink( $attrs, $prepend );
	}


	public function addJs(
		string $src,
		array $attrs = [],
		string $where = 'body',
		bool $prepend = false
	) : void {

		$defaults = [
			'src' => $src,
		];

		$attrs = array_merge( $defaults, $attrs );

		$this->addScript( $attrs, $where, $prepend );
	}


	public function addJsCdata(
		string $cdata,
		array $attrs = [],
		string $where = 'body',
		bool $prepend = false
	) : void {

		$defaults = [
			'cdata' => $cdata,
		];

		$attrs = array_merge( $defaults, $attrs );

		$this->addScript( $attrs, $where, $prepend );
	}


	// -----------------------------------------------


	public function buildMetaTags() : string {
		return self::buildTags( 'meta', $this->get( 'meta' ) );
	}


	public function buildLinkTags() : string {
		return self::buildTags( 'link', $this->get( 'link' ) );
	}


	public function buildScriptTags( string $where = 'body' ) : string {
		return self::buildTags( 'script', $this->get( "script_{$where}" ) );
	}


	// -----------------------------------------------


	public static function buildTag( string $tag, array $attrs = [] ) : string {
		$is_void = in_array( $tag, [ 'link', 'meta' ], true );

		$html = "<{$tag}";

		foreach ( $attrs as $k => $v ) {
			if ( $k !== 'cdata' ) {
				$html .= sprintf( ' %s="%s"', $k, htmlspecialchars( $v ) );
			}
		}

		$html .= '>';

		if ( ! $is_void ) {
			$html .= $attrs['cdata'] ?? '';
			$html .= "</{$tag}>";
		}

		return $html;
	}


	public static function buildTags( string $tag, array $items ) : string {
		$html = '';

		foreach ( $items as $attrs ) {
			$html .= self::buildTag( $tag, $attrs );
		}

		return $html;
	}

}
