// Defining requirements
var gulp = require("gulp");
var plumber = require("gulp-plumber");
var sass = require("gulp-sass");
var babel = require("gulp-babel");
var postcss = require("gulp-postcss");
var watch = require("gulp-watch");
var rename = require("gulp-rename");
var concat = require("gulp-concat");
var uglify = require("gulp-uglify");
var imagemin = require("gulp-imagemin");
var ignore = require("gulp-ignore");
var merge = require("merge-stream");
var rimraf = require("gulp-rimraf");
var sourcemaps = require("gulp-sourcemaps");
var browserSync = require("browser-sync").create();
var del = require("del");
var cleanCSS = require("gulp-clean-css");
var gulpSequence = require("gulp-sequence");
var replace = require("gulp-replace");
var strreplace = require("gulp-string-replace");
var autoprefixer = require("autoprefixer");
var wppot = require("gulp-wp-pot");
var zip = require("gulp-zip");
var purgecss = require("gulp-purgecss");
var removeCode = require("gulp-remove-code");

// Configuration file to keep your code DRY
var cfg = require("./gulpconfig.json");
var paths = cfg.paths;

// Run:
// gulp sass
// Compiles SCSS files in CSS
gulp.task("sass", function() {
	var stream = gulp
		.src(paths.sass + "/*.scss")
		.pipe(
			plumber({
				errorHandler: function(err) {
					console.log(err);
					this.emit("end");
				}
			})
		)
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(sass({ errLogToConsole: true }))
		.pipe(postcss([autoprefixer()]))
		.pipe(sourcemaps.write(undefined, { sourceRoot: null }))
		.pipe(gulp.dest(paths.css));
	return stream;
});

// Run:
// gulp watch
// Starts watcher. Watcher runs gulp sass task on changes
gulp.task("watch", function() {
	gulp.watch(`${paths.sass}/**/*.scss`, gulp.series("styles"));
	gulp.watch(
		[
			`${paths.dev}/js/**/*.js`,
			"js/**/*.js",
			"!js/theme.js",
			"!js/theme.min.js"
		],
		gulp.series("scripts")
	);

	//Inside the watch task.
	gulp.watch(`${paths.imgsrc}/**`, gulp.series("imagemin-watch"));
});

// Run:
// gulp imagemin
// Running image optimizing task
gulp.task("imagemin", function() {
	return gulp;
});

// Run:
// gulp cssnano
// Minifies CSS files
gulp.task("cssnano", function() {
	return gulp
		.src(paths.css + "/theme.css")
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(
			plumber({
				errorHandler: function(err) {
					console.log(err);
					this.emit("end");
				}
			})
		)
		.pipe(rename({ suffix: ".min" }))
		.pipe(cssnano({ discardComments: { removeAll: true } }))
		.pipe(sourcemaps.write("./"))
		.pipe(gulp.dest(paths.css));
});

gulp.task("minifycss", function() {
	return gulp
		.src(`${paths.css}/theme.css`)
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(cleanCSS({ compatibility: "*" }))
		.pipe(
			plumber({
				errorHandler: function(err) {
					console.log(err);
					this.emit("end");
				}
			})
		)
		.pipe(rename({ suffix: ".min" }))
		.pipe(sourcemaps.write("./"))
		.pipe(gulp.dest(paths.css));
});

gulp.task("cleancss", function() {
	return gulp
		.src(`${paths.css}/*.min.css`, { read: false }) // Much faster
		.pipe(ignore("theme.css"))
		.pipe(rimraf());
});

gulp.task("styles", function(callback) {
	gulp.series("sass", "minifycss")(callback);
});

gulp.task("purgecss", function() {
	return gulp
		.src(paths.css + "/*.css")
		.pipe(
			purgecss({
				content: [paths.public + "/**/*.php", paths.private + "/**/*.php"],
				whitelist: [],
				whitelistPatterns: []
			})
		)
		.pipe(rename({ basename: "theme-purged" }))

		.pipe(gulp.dest(paths.css));
});

gulp.task("purgecss-rejected", function() {
	return gulp
		.src(paths.css + "/theme.css")
		.pipe(
			rename({
				suffix: ".rejected"
			})
		)
		.pipe(
			purgecss({
				content: [
					paths.public + "**/*.php",
					paths.private + "**/*.php",
					"!node_modules/",
					"!sass/",
					"!src/",
					"!vendor/"
				],
				rejected: true
			})
		)
		.pipe(gulp.dest(paths.css));
});

gulp.task("remove-dev-code", function() {
	return gulp
		.src(["dist/**/*.php", "!dist/vendor/"])
		.pipe(removeCode({ production: true }))
		.pipe(gulp.dest("dist"));
});

gulp.task("fonts", function() {
	return gulp
		.src(paths.fonts + "/**.*")
		.pipe(gulp.dest(paths.dist + "/fonts/"));
});

gulp.task("images", function() {
	return gulp
		.src([paths.img + "/**/*.*", paths.img + "/*.*"])
		.pipe(gulp.dest(paths.dist + "/images/"));
});

// Run:
// gulp browser-sync
// Starts browser-sync task for starting the server.
gulp.task("browser-sync", function() {
	browserSync.init(cfg.browserSyncWatchFiles, cfg.browserSyncOptions);
});

// Run:
// gulp scripts.
// Uglifies and concat all JS files into one
gulp.task("scripts", function() {
	var scripts = [
		// Start - All BS4 stuff
		`${paths.src}/js/bootstrap4/bootstrap.bundle.js`,

		// End - All BS4 stuff

		`${paths.src}/js/skip-link-focus-fix.js`,

		// Adding currently empty javascript file to add on for your own themes´ customizations
		// Please add any customizations to this .js file only!
		`${paths.src}/js/custom-javascript.js`
	];
	gulp
		.src(scripts, { allowEmpty: true })
		.pipe(
			babel({
				presets: ["@babel/preset-env"]
			})
		)
		.pipe(concat("theme.min.js"))
		.pipe(uglify())
		.pipe(gulp.dest(paths.js));

	return gulp
		.src(scripts, { allowEmpty: true })
		.pipe(babel())
		.pipe(concat("theme.js"))
		.pipe(gulp.dest(paths.js));
});

// Deleting any file inside the /src folder
gulp.task("clean-source", function() {
	return del(["src/**/*"]);
});

// Run:
// gulp watch-bs
// Starts watcher with browser-sync. Browser-sync reloads page automatically on your browser
gulp.task("watch-bs", gulp.parallel("browser-sync", "watch"));

// Run:
// gulp copy-assets.
// Copy all needed dependency assets files from bower_component assets to themes /js, /scss and /fonts folder. Run this task after bower install or bower update

////////////////// All Bootstrap SASS  Assets /////////////////////////
gulp.task("copy-assets", function(done) {
	////////////////// All Bootstrap 4 Assets /////////////////////////
	// Copy all JS files
	var stream = gulp
		.src(`${paths.node}bootstrap/dist/js/**/*.js`)
		.pipe(gulp.dest(`${paths.dev}/js/bootstrap4`));

	// Copy all Bootstrap SCSS files
	gulp
		.src(`${paths.node}bootstrap/scss/**/*.scss`)
		.pipe(gulp.dest(`${paths.dev}/sass/bootstrap4`));

	////////////////// End Bootstrap 4 Assets /////////////////////////

	// Copy all Font Awesome Fonts
	gulp
		.src(`${paths.node}font-awesome/fonts/**/*.{ttf,woff,woff2,eot,svg}`)
		.pipe(gulp.dest("./fonts"));

	// Copy all Font Awesome SCSS files
	gulp
		.src(`${paths.node}font-awesome/scss/*.scss`)
		.pipe(gulp.dest(`${paths.dev}/sass/fontawesome`));

	// _s SCSS files
	gulp
		.src(`${paths.node}undescores-for-npm/sass/media/*.scss`)
		.pipe(gulp.dest(`${paths.dev}/sass/underscores`));

	// _s JS files into /src/js
	gulp
		.src(`${paths.node}undescores-for-npm/js/skip-link-focus-fix.js`)
		.pipe(gulp.dest(`${paths.dev}/js`));

	// Copy all MDBootstrap SCSS files
	gulp
		.src(`${paths.node}mdboostrap/scss/**/*.scss`)
		.pipe(gulp.dest(`${paths.dev}/sass/mdboostrap`));

	done();
});

gulp.task("update-src", function() {
	// Copy All Bootstrap Files
	var bootstrapjs = gulp
		.src(`${paths.node}/bootstrap/dist/js/**/*.js`)
		.pipe(gulp.dest(`${paths.src}/js/bootstrap4`));

	var bootstrap = gulp
		.src([
			paths.node + "/bootstrap/scss/*/*.scss",
			paths.node + "/bootstrap/scss/*.scss"
		])
		.pipe(gulp.dest(paths.src + "/sass/bootstrap4/"));

	// Copy all Font Awesome Fonts
	var fonts = gulp
		.src(`${paths.node}/font-awesome/fonts/**/*.{ttf,woff,woff2,eot,svg}`)
		.pipe(gulp.dest(paths.fonts));

	// Copy all Font Awesome SCSS files
	var fontawesome = gulp
		.src(paths.node + "/font-awesome/scss/*.scss")
		.pipe(gulp.dest(paths.src + "/sass/fontawesome/"));

	return merge(bootstrapjs, bootstrap, fonts, fontawesome);
});

// Deleting the files distributed by the copy-assets task
gulp.task("clean-vendor-assets", function() {
	return del([
		`${paths.dev}/js/bootstrap4/**`,
		`${paths.dev}/sass/bootstrap4/**`,
		"./fonts/*wesome*.{ttf,woff,woff2,eot,svg}",
		`${paths.dev}/sass/fontawesome/**`,
		`${paths.dev}/sass/underscores/**`,
		`${paths.dev}/js/skip-link-focus-fix.js`,
		`${paths.js}/**/skip-link-focus-fix.js`,
		`${paths.js}/**/popper.min.js`,
		`${paths.js}/**/popper.js`,
		paths.vendor !== "" ? paths.js + paths.vendor + "/**" : ""
	]);
});

// Deleting any file inside the /dist folder
gulp.task("clean-dist", function() {
	return del([paths.dist + "/**"]);
});

// Delete empty folders from /dist folder
gulp.task("clean-empty", function() {
	return del([
		paths.dist + "/node_modules",
		paths.dist + "/sass",
		paths.dist + "/src",
		paths.vendor
	]);
});

// Run
// gulp translate
// Generate translation files.
// gulp.task("translate", function() {
// 	return gulp
// 		.src(paths.languages)
// 		.pipe(
// 			wppot({
// 				domain: cfg.theme.slug,
// 				package: cfg.theme.name,
// 				bugReport: cfg.theme.name,
// 				lastTranslator: cfg.theme.author
// 			})
// 		)
// 		.pipe(gulp.dest(paths.dist + "/languages/" + cfg.theme.slug + ".pot"));
// });

// Run
// gulp dist
// Copies the files to the /dist folder for distribution as simple theme
gulp.task(
	"dist",
	gulp.series(["clean-dist"], function() {
		return gulp
			.src(
				[
					"**/*",
					`!${paths.bower}`,
					`!${paths.bower}/**`,
					`!${paths.node}`,
					`!${paths.node}/**`,
					`!${paths.src}`,
					`!${paths.src}/**`,
					`!${paths.dist}`,
					`!${paths.dist}/**`,
					`!${paths.distprod}`,
					`!${paths.distprod}/**`,
					`!${paths.sass}`,
					`!${paths.sass}/**`,
					"!readme.txt",
					"!readme.md",
					"!package.json",
					"!package-lock.json",
					"!gulpfile.js",
					"!gulpconfig.json",
					"!CHANGELOG.md",
					"!.travis.yml",
					"!jshintignore",
					"!codesniffer.ruleset.xml",
					"!" + paths.node,
					"!" + paths.node + "/**/*",
					"*"
				],
				{ buffer: true }
			)
			.pipe(
				replace(
					"/js/jquery.slim.min.js",
					"/js" + paths.vendor + "/jquery.slim.min.js",
					{ skipBinary: true }
				)
			)
			.pipe(
				replace("/js/popper.min.js", "/js" + paths.vendor + "/popper.min.js", {
					skipBinary: true
				})
			)
			.pipe(
				replace(
					"/js/skip-link-focus-fix.js",
					"/js" + paths.vendor + "/skip-link-focus-fix.js",
					{ skipBinary: true }
				)
			)
			.pipe(strreplace("understrap", cfg.theme.slug))
			.pipe(strreplace("UnderStrap", cfg.theme.name))
			.pipe(gulp.dest(paths.dist));
	})
);

// Deleting any file inside the /dist-product folder
gulp.task("clean-dist-product", function() {
	return del([paths.distprod + "/**"]);
});

// Run
// gulp dist-product
// Copies the files to the /dist-prod folder for distribution as theme with all assets
gulp.task(
	"dist-product",
	gulp.series(["clean-dist-product"], function() {
		return gulp
			.src([
				"**/*",
				`!${paths.bower}`,
				`!${paths.bower}/**`,
				`!${paths.node}`,
				`!${paths.node}/**`,
				`!${paths.dist}`,
				`!${paths.dist}/**`,
				`!${paths.distprod}`,
				`!${paths.distprod}/**`,
				"*"
			])
			.pipe(gulp.dest(paths.distprod));
	})
);

// Run
// gulp compile
// Compiles the styles and scripts and runs the dist task
gulp.task("compile", gulp.series("styles", "scripts", "purgecss"));

// Run:
// gulp
// Starts watcher (default task)
gulp.task("default", gulp.series("watch"));

/**
 * Create zip archive from generated theme files.
 */
gulp.task(
	"bundle",
	gulp.series("dist", "fonts", "remove-dev-code"),
	function() {
		return gulp
			.src([paths.dist + "/**"])
			.pipe(
				zip(cfg.theme.slug + ".zip"),
				gulp.dest(paths.theme + cfg.theme.slug)
			)
			.pipe(gulp.dest(paths.theme));
	}
);
