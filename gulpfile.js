const gulp = require('gulp');
const git = require('gulp-git');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const wpPot = require('gulp-wp-pot');
const cleanCSS = require('gulp-clean-css');

const config = {
  scripts: [
    './assets/js/basic_config_mercadopago.js',
    './assets/js/basic-cho.js',
    './assets/js/credit-card.js',
    './assets/js/custom_config_mercadopago.js',
    './assets/js/ticket_config_mercadopago.js',
    './assets/js/ticket.js',
		'./assets/js/pix_config_mercadopago.js',
    './assets/js/review.js',
    './assets/js/pix_mercadopago_order_received.js',
  ],
  stylesheets: [
    './assets/css/admin_notice_mercadopago.css',
    './assets/css/basic_checkout_mercadopago.css',
    './assets/css/config_mercadopago.css',
  ]
};

gulp.task('scripts', function() {
  return gulp.src(config.scripts)
    .pipe(uglify())
    .pipe(rename({ extname: '.min.js' }))
    .pipe(gulp.dest('./assets/js/'));
});

gulp.task('stylesheets', () => {
  return gulp.src(config.stylesheets)
    .pipe(cleanCSS({ compatibility: 'ie8' }))
    .pipe(rename({ extname: '.min.css' }))
    .pipe(gulp.dest('./assets/css/'));
});

gulp.task('wpPot', function () {
  return gulp.src('**/*.php')
        .pipe(wpPot( {
            domain: 'woocommerce-mercadopago',
            lastTranslator: 'MPB Desenvolvimento <mpb_desenvolvimento@mercadopago.com.br>',
        } ))
        .pipe(gulp.dest('./i18n/languages/woocommerce-mercadopago.pot'));
});

gulp.task('git-add', function() {
  return gulp.src('.')
    .pipe(git.add());
});

gulp.task('pre-commit', gulp.series('scripts', 'stylesheets', 'wpPot', 'git-add'));

// npx jshint assets/**/*.js
// minificar js e css
// executar jshint para poder verificar sintaxe
// wppot
// pre-commit executar todos essas tasks