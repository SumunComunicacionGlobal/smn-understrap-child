'use strict';

const process = require( 'process' );

const colors = [
	'primary',
	'secondary',
	'light',
	'dark',
	'black',
	'white',
	'gray',
	'gray-dark',
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
