module.exports = function(grunt){
  require('time-grunt')(grunt);

  //timer.init(grunt);
  require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

  grunt.initConfig({

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
          // data: grunt.file.readJSON(pathJade)
          // data: function(dest, src) {
          //   // Return an object of data to pass to templates
          //   return require('./new/jade/vars.json');
          // },
          // filters: {
          //   json : function (str) {
          //     return JSON.stringify(JSON.parse(str));
          //   }
          // }
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
          // стили страницы вакансий
          'stylesheets/vacancy.css': ['less/vacancy.less'],
          // стили html баннеров, независимы от всего 
          // 'stylesheets/banner.css': ['less/banner.less']
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
          /*sourceMapFilename: 'new/css/all1.css.map',*/
          /*sourceMapRootpath: 'new/css',
          sourceMapURL: 'new/css/all1.css.map',*/
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
      },
      aviary: {
        files: {
          'new/css/plugins/aviary.hg.css': ['new/less/plugins/aviary.hg.less'] 
        },
        options: {
          compress: true,
          cleancss: true,
        }
      }
    },


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
      newless: {
        files: ['new/less/**/*.less'],
        tasks: ['less:newest', 'less:newestdev', /*'cmq','cssmin', 'csso'*/ ],
        options: {
          livereload: true,
        },
      },
      // следим за новым less
      aviary: {
        files: ['new/less/**/aviary.hg.less'],
        tasks: ['less:aviary'],
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

    // Удаляем файлы
    // clean: {
    //   new: ['new/css/tidy.css']
    // },

    //чистим css от не используемых стилей
    uncss: {
      new: {
        options: {
          stylesheets  : ['/css/all1.dev.css'],
          timeout      : 1000,

          htmlroot     : 'new',
          ignore       : [
            // Выбираем все стили где в начале .select2
            /.dropdown+/,
            /.jcrop+/,
            /.mfp+/,
            /.redactor+/,
            /.select2+/,
            /.tooltip+/,
          ],
        },
        src: ['new/html/docs/*.html', 'new/html/page/**/*.html'],
        dest: 'new/css/all1.dev.css'
      },
    },

    // Объеденяем медиа запросы в css
    cmq: {
      options: {
        log: true
      },
      new: {
        files: {
          'new/css': ['new/css/all1.dev.css']
        }
      }
    },

    // Сжимаем css
    cssmin: {
      dist: {
        options: {
          compatibility: 'ie8',
          keepSpecialComments: 0,
          report: 'max'
        },
        files: {
          'new/css/all1.dev.css': 'new/css/all1.dev.css'
        }
      }
    },
    csso: {
      compress: {
        options: {
          report: 'gzip'
        },
        files: {
          'new/css/all1.css': ['new/css/all1.dev.css']
        }
      }
    },

    csscomb: {
      options: {
          config: 'new/less/bootstrap/.csscomb.json'
      },
      aviary: {
          files: {
              'new/less/plugins/aviary.hg.less': ['new/less/plugins/aviary.hg.less'],
          },
      },
        
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

  // grunt.loadNpmTasks('grunt-merge-json');
  // grunt.loadNpmTasks('grunt-contrib-jade');
  // grunt.loadNpmTasks('grunt-newer');
  // grunt.loadNpmTasks('grunt-contrib-less');
  // grunt.loadNpmTasks('grunt-contrib-watch');
  // grunt.loadNpmTasks('grunt-contrib-connect');
  // grunt.loadNpmTasks('grunt-contrib-imagemin');
  // grunt.loadNpmTasks('grunt-newer');
  // grunt.loadNpmTasks('grunt-uncss');

  grunt.registerTask('bild', ['css', 'jade']);
  grunt.registerTask('css', ['less:newestdev','uncss', 'cmq', 'cssmin', 'csso']);
  grunt.registerTask('default', [
    'connect',
    // 'uncss',
    // 'merge-json',
    'watch', 
  ]);

  // grunt.event.on('watch', function(action, filepath, target) {

  // });



};
