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
    }

  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['cssmin:target', 'uglify:target']);
};