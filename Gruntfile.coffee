module.exports = (grunt) ->
  grunt.initConfig

    copy:
      fonts:
        files: [
          expand: true
          flatten: true
          cwd: 'node_modules'
          src: [
            'live-form-validation/live-form-validation.js'
          ]
          dest: 'assets'
        ]

  grunt.loadNpmTasks 'grunt-contrib-copy'

  grunt.registerTask 'default', [
    'copy'
  ]
