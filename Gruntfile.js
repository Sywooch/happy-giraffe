module.exports = function(grunt){
  var timer = require("grunt-timer");

  timer.init(grunt);

  // json for jade 
  // var pathJade = "new/jade/array/*";


  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    // Собираем все json в один
    // 'merge-json': {
    //     jadevars: {
    //         src: [ "new/jade/json/**/*.json" ],
    //         dest: "new/jade/vars.json"
    //     },
    // },
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
          'stylesheets/vacancy.css': ['less/vacancy.less']
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
      // Следим за json
      // 'merge-json': {
      //   files: ['new/jade/json/**/*.json'],
      //   tasks: ['merge-json'],
      //   options: {
      //     spawn: false,
      //     livereload: true,
      //   },
      // },
      // Следим за изменениями миксинов и унаследованных файлов
      jadereload: {
        files: ['new/jade/block/**/*.jade', 'new/jade/extend/**/*.jade'],
        tasks: ['jade:all'],
        options: {
          spawn: false,
          livereload: true,
        },
      },
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
    // 'merge-json',
    'watch', 
  ]);

  grunt.event.on('watch', function(action, filepath, target) {

    // Перешли на плагин newer //
    // Земеняем в пути к измененному файлу jade/page на html
    // var destFilePath = filepath.replace(/jade\\page/, 'html');
    // Изменяем расширение файла
    // grunt.log.write(action + ' ------- ' + target);


    // if (target == 'jade') {
    //   var destFilePath = filepath.replace(/jade/g, 'html');
    //   grunt.log.write(filepath + ' ------- ' + destFilePath);
    //   // 'page' task jade 
    //   grunt.config(['jade', 'page', 'files'], [
    //     {src: filepath, dest: destFilePath }
    //   ]);
    // }


  });



};
