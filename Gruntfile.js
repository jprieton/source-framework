module.exports = function (grunt) {
  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    cssmin: {
      options: {
        mergeIntoShorthands: false,
        roundingPrecision: -1
      },
      target: {
        files: {
          'assets/css/admin.min.css': ['assets/css/admin.css'],
          'assets/css/public.min.css': ['assets/css/public.css'],
          'assets/css/hentry.min.css': ['assets/css/hentry.css'],
          'assets/css/breakpoint-helper.min.css': ['assets/css/breakpoint-helper.css']
        }
      }
    },

    compress: {
      build: {
        options: {
          archive: '../source-framework.zip'
        },
        files: [
          {
            src: [
              '*.php',
              'assets/**',
              'includes/**',
              'languages/**',
              'partials/**'
            ],
            dest: 'smg-tools'
          }
        ]
      }
    },

    concat: {
      options: {
        separator: ''
      },
      admin: {
        src: ['src/assets/js/_admin-*.js'],
        dest: 'assets/js/admin.js'
      },
      public: {
        src: ['src/assets/js/_public-*.js'],
        dest: 'assets/js/public.js'
      }
    },

    less: {
      development: {
        options: {
          paths: ['src/assets/less']
        },
        files: {
          'assets/css/admin.css': 'src/assets/less/admin.less',
          'assets/css/public.css': 'src/assets/less/public.less',
          'assets/css/hentry.css': 'src/assets/less/hentry.less',
          'assets/css/breakpoint-helper.css': 'src/assets/less/breakpoint-helper.less'
        }
      }
    },

    uglify: {
      options: {
        mangle: {
          reserved: ['jQuery', '$']
        }
      },
      target: {
        files: {
          'assets/js/public.min.js': ['assets/js/public.js'],
          'assets/js/admin.min.js': ['assets/js/admin.js'],
          'assets/js/breakpoint-helper.min.js': ['assets/js/breakpoint-helper.js']
        }
      }
    },

    watch: {
      less: {
        files: ["src/assets/less/*.less"],
        tasks: ['less:development'],
        options: {
          interrupt: true
        }
      },
      css: {
        files: ['assets/css/admin.css', 'assets/css/hentry.css', 'assets/css/breakpoint-helper.css'],
        tasks: ['cssmin:target'],
        options: {
          interrupt: true
        }
    },
      concat: {
        files: ["src/assets/js/_admin-*.js", "src/assets/js/_public-*.js"],
        tasks: ["concat:admin", "concat:public"],
      options: {
          interrupt: true
      }
    },
      js: {
        files: ['assets/js/public.js', 'assets/js/admin.min.js', 'assets/js/breakpoint-helper.min.js'],
        tasks: ['uglify:target'],
        options: {
          interrupt: true
          }
      }
    }

  } );

  grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
  grunt.loadNpmTasks( 'grunt-contrib-compress' );
  grunt.loadNpmTasks( 'grunt-contrib-concat' );
  grunt.loadNpmTasks( 'grunt-contrib-less' );
  grunt.loadNpmTasks( 'grunt-contrib-uglify' );
  grunt.loadNpmTasks( 'grunt-contrib-watch' );

  // Default task(s).
  grunt.registerTask( "default", ["cssmin:target", "uglify:target"] );
  grunt.registerTask( "build", ["less:development", "cssmin:target", "uglify:target", "compress:build"] );
};