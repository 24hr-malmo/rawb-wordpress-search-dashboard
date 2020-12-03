module.exports = function(api) {
    api.cache.forever();

    return {
        "presets": [
            "solid",
            [
                "@babel/preset-env",
                {
                    "targets": {
                        "chrome": "80"
                    }
                }
            ]
        ],
        "plugins": [
            // "emotion"
        ]
    }

};
