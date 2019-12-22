module.exports = (grunt) ->
  grunt.initConfig

    clean:
      dist: [
        'assets/generated'
      ]


    concat:
      admin:
        dest: 'assets/generated/custom-admin.css'
        src: [
          'bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css'
          'bower_components/ublaboo-datagrid/assets/dist/datagrid.css'
        ]
      adminjs:
        dest: 'assets/generated/full-admin.js'
        src: [
          'bower_components/bootbox/bootbox.js'
          'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'
          'bower_components/bootstrap-maxlength/src/bootstrap-maxlength.js'
          'bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js'
          'bower_components/nette-live-form-validation/live-form-validation.js'
          'bower_components/ublaboo-datagrid/assets/dist/datagrid.js'
        ]

  grunt.loadNpmTasks 'grunt-contrib-concat'
  grunt.loadNpmTasks 'grunt-contrib-clean'

  grunt.registerTask 'default', [
    'clean'
    'concat'
  ]
