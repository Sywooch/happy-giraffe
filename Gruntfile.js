module.exports = function(grunt){
  var timer = require("grunt-timer");

  timer.init(grunt);

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    jade: {
      
      // Пересобираем все шаблоны
      all: {
        files: [{
          expand: true,
          cwd: 'new/jade',
          src: ['page/**/*.jade', '!block/**/*.jade', '!extend/**/*.jade'],
          dest: 'new/html',
          ext: ".html"
        }],
        options: {
          pretty: true,
          client: false,
          cache: true,
          nospawn : true,
        }
      },
      // пересобираем документацию
      docs: {
        files: [{
          expand: true,
          cwd: 'new/jade',
          src: ['docs/**/*.jade', ],
          dest: 'new/html',
          ext: ".html"
        }],
        options: {
          pretty: true,
          client: false,
          cache: true,
          nospawn : true,
          // data: grunt.file.readJSON(pathJade)
        }
      }
    },

    
    less: {
      old: {
        files: {
          'stylesheets/common.css': ['less/all1.less'],
          'stylesheets/global.css': ['less/all2.less'],
        },
        options: {
          compress: true,
          cleancss: true,
          // sourceMap: true,
          // sourceMapFilename: 'css/all.css.map',
          // sourceMapRootpath: '',
          // sourceMapBasepath: ''
        }
      },
      old_dev: {
        files: {
          'stylesheets/common.dev.css': ['less/all1.less'],
          'stylesheets/global.dev.css': ['less/all2.less'],
          // Стили для страниц вакансии
          //'stylesheets/vacancy.css': ['less/vacancy.less']
        },
        options: {
          sourceMap: true,
          // sourceMapFilename: 'css/all.css.map',
          // sourceMapRootpath: '',
          // sourceMapBasepath: ''
        }
      },
      newestdev: {
        files: {
          'new/css/all1.dev.css': ['new/less/all1.less'] 
        },
        options: {
          sourceMap: true,
          sourceMapFilename: 'new/css/all1.css.map',
          sourceMapRootpath: '../../',
          //sourceMapURL: 'all1.css.map',
        }
      },
      newest: {
        files: {
          'new/css/all1.css': ['new/less/all1.less'] 
        },
        options: {
          compress: true,
          cleancss: true,
        }
      }
    },

    // imagemin: {
    //   dynamic: {
    //     files: [{
    //       expand: true,
    //       cwd: 'new/images',
    //       src: ['**/*.{png,jpg,gif}'],
    //       dest: 'new/images1',
    //     }],
    //     options: {
    //         cache: false
    //     }
    //   }
    // },

    watch: {
      // Следим за статическими страницами
      jadepage: {
        files: ['new/jade/page/**/*.jade'],
        tasks: ['newer:jade:all'],
        options: {
          spawn: false,
          livereload: true,
        },
      },
      // Пересобираем документацию
      jadedocs: {
        files: ['new/jade/docs/**/*.jade'],
        tasks: ['jade:docs'],
        options: {
          spawn: false,
          livereload: true,
        },
      },
      // Следим за старым less 
      lessold: {
        files: ['less/**/*.less'],
        tasks: ['less:old', 'less:old_dev'],
        options: {
          livereload: true,
        },
      },
      // следим за новым less
      less: {
        files: ['new/less/**/*.less'],
        tasks: ['less:newest', 'less:newestdev'],
        options: {
          livereload: true,
        },
      },
      // Следим за изменениями в рассылках
      email: {
        files: ['new/html/email/**/*'],
        // tasks:['less:newest'],
        options: {
          livereload: true,
        },
      },
      // imagemin: {
      //   files: ['new/images/**/*.{png,jpg,gif}'],
      //   tasks: ['newer:imagemin'],
      // }
    },
    // Поднимаем сервер
    connect: {
      server: {
        options: {
          port: 4000,
          base: '.',
        }
      }
    },
  });

  grunt.loadNpmTasks('grunt-merge-json');
  grunt.loadNpmTasks('grunt-contrib-jade');
  grunt.loadNpmTasks('grunt-newer');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-connect');
  grunt.loadNpmTasks('grunt-contrib-imagemin');
  grunt.loadNpmTasks('grunt-newer');

  grunt.registerTask('default', [
    'connect',
    // 'less',
    'watch', 
  ]);
  grunt.registerTask('all', [
    'less',
    'jade', 
  ]);
  grunt.registerTask('push', [
    'less',
    //'jade', 
  ]);

  grunt.event.on('watch', function(action, filepath, target) {});



};
