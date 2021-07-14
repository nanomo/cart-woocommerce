const gulp = require('gulp');
const wpPot = require('gulp-wp-pot');
const fs = require('fs');
const path = require('path');
const minify = require('minify');

function minifyJSFiles() {
    const assetsJSPath = path.resolve('./assets/js');
    const assetsFiles =fs.readdirSync(assetsJSPath);
    const jsFiles = assetsFiles.filter(filePath => filePath.includes('.js') && !filePath.includes('.min'));
    const options = {js: {ecma: 6}};

    jsFiles.forEach(file => {
        const filePath = path.resolve(`${assetsJSPath}/${file}`);
    
        minify(filePath, options)
            .then(minifiedContent => {
                const newFilePathName = filePath.split('.js')[0].concat('.min.js');
                fs.writeFileSync(newFilePathName, minifiedContent);
            })
            .catch(console.error);
    });
}

function minifyCSSFiles() {
    const assetsCSSPath = path.resolve('./assets/css');
    const assetsFiles =fs.readdirSync(assetsCSSPath);
    const cssFiles = assetsFiles.filter(filePath => filePath.includes('.css') && !filePath.includes('.min'));
    const options = {css: {compatibility: '*'}};

    cssFiles.forEach(file => {
        const filePath = path.resolve(`${assetsCSSPath}/${file}`);
    
        minify(filePath, options)
            .then(minifiedContent => {
                const newFilePathName = filePath.split('.css')[0].concat('.min.css');
                fs.writeFileSync(newFilePathName, minifiedContent);
            })
            .catch(console.error);
    });
}

gulp.task('wpPot', function () {
  return gulp.src('**/*.php')
        .pipe(wpPot( {
            domain: 'woocommerce-mercadopago',
            lastTranslator: 'MPB Desenvolvimento <mpb_desenvolvimento@mercadopago.com.br>',
        } ))
        .pipe(gulp.dest('./i18n/languages/woocommerce-mercadopago.pot'));
});

module.exports = {minifyJSFiles, minifyCSSFiles};