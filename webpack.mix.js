const mix = require("laravel-mix");

// admin
mix.js("resources/admin/js/main.js", "public/admin")
    .vue()
    .postCss("resources/admin/css/main.css", "public/admin", [
        require("autoprefixer"),
    ]);

// frontend
mix.js("resources/frontend/js/main.js", "public/frontend")
    .vue()
    .postCss("resources/frontend/css/main.css", "public/frontend", [
        require("autoprefixer"),
    ]);
