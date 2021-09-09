module.exports = {
    purge: [
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            fontFamily: {
                sourcesans: "'Source Sans Pro', sans-serif",
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
};
