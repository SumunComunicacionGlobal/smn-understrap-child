'use strict';

const process = require( 'process' );

const colors = [
	'primary',
	'secondary',
	'light',
	'dark',
	'black',
	'white',
	'white-body',
	'light',
	'dark',
	'gray',
	'gray-dark',
	'body',
];

module.exports = ( ctx ) => {
	return {
		map: {
			inline: false,
			annotation: true,
			sourcesContent: true,
		},
		plugins: {
			autoprefixer: {
				cascade: false,
				env: 'bs5',
			},
			'postcss-understrap-palette-generator': {
				colors: colors.map( ( x ) => `--${ 'bs-' }${ x }` ),
			},
		},
	};
};
