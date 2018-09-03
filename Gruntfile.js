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
          'assets/css/public.min.css': ['assets/css/public.css']
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
          'assets/js/admin.min.js': ['assets/js/admin.js'],
          'assets/js/public.min.js': ['assets/js/public.js']
        }
      }
    },

    watch: {
      js: {
        files: ['assets/js/admin.js', 'assets/js/public.js'],
        tasks: ['uglify:target'],
        options: {
          interrupt: true
        }
      },
      css: {
        files: ['assets/css/admin.css', 'assets/css/public.css'],
        tasks: ['cssmin:target'],
        options: {
          interrupt: true
        }
      }
    },

    shell: {
      options: {
        stderr: false
      },
      build: {
        command: 'php ./src/build.php'
      }
    },

    compress: {
      build: {
        options: {
          archive: 'dist/source-framework.zip'
        },
        files: [
          {
            src: ['source-framework.php', '*.phar', 'LICENSE', 'assets/**', 'languages/**', 'templates/**'],
            dest: 'source-framework/'
          }
        ]
      }
    },

    clean: {
      folder: ['dist'],
      phar: ['*.phar']
    }

  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-shell');
  grunt.loadNpmTasks('grunt-contrib-compress');
  grunt.loadNpmTasks('grunt-contrib-clean');

  // Default task(s).
  grunt.registerTask('build', ['cssmin:target', 'uglify:target', 'compress:build']);
};