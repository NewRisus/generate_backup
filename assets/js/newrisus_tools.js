$('.bdc').on('click', function(e) {
	tipo = $(this).children().attr('id');
	location.href = global.url + '/index.php?accion=' + tipo;
});

$("input[name=newname]").on('keyup', function() {
   $.post({
      url: global.url + '/app.php?act=check',
      data: 'text=' + $(this).val(),
      cache: false,
   }).done(function(h) {
      switch (h.charAt(0)) {
         case '0':
            $("input[name=newname]").addClass('is-invalid').removeClass('is-valid');
            $(".msga").addClass('text-danger').removeClass('text-muted').html(h.substring(3));
         break;
         case '1': 
            $("input[name=newname]").addClass('is-valid').removeClass('is-invalid');
            $(".msga").addClass('text-muted').removeClass('text-danger').html(h.substring(3));
         break;
      }      
   });
});

var generator = {
   crear: function() {
      // Capturamos todos los campos
      dataString = $('#cuenta-backup').serialize();
      dataString += '&save=' + global.pagina;
      // Lo enviamos usando el método POST
      $.post({
         url: global.url + '/app.php?act=create', 
         data: dataString,
         beforeSend: function() {
            $(".generated").html('<span id="spin" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creando backup...');
         }
      }).done(function(h) {
      	Swal.fire({
				icon: (h.charAt(0) == '1') ? 'success' : 'error',
				title: (h.charAt(0) == '1') ? 'Bien' : 'Error',
				html: h.substring(3),
  				showCancelButton: true,
				confirmButtonText: `Finalizar`,
			}).then((result) => {
				if (result.isConfirmed) location.href = global.url + '/index.php';
			});
      }).always(function(){
         $(".generated").html('Guardar');
      });
   },
   restaurar: function(id, file, ext) {
      $.post({
         url: global.url + '/app.php?act=restore', 
         data: {id, file, ext},
         beforeSend: function() {
            $(".id_"+id).html('<span id="spin" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Restaurando base...');
            $("#alerta").html('<small class="d-block text-center py-2 text-danger">Este proceso puede tardar, así que debes ser paciente hasta que termine.</small>');
         }
      }).done(function(e) {
         klass = (e.charAt(0) == '1') ? 'success' : 'error';
         Swal.fire({icon:klass,html:e.substring(3)});
      }).always(function(){
         $(".id_"+id).html('Restaurar');
         $("#alerta").html('');
      });;
   },
   eliminar: function(id, file, ext) {
      $.post(global.url + '/app.php?act=delete', {id, file, ext}, function(e) {
         //console.log(e);
         klass = (e.charAt(0) == '0') ? 'error' : 'success';
         Swal.fire({icon:klass,html:e.substring(3)});
         if(e.charAt(0) == '1') {
            $('#' + id).remove();
            $('#total > b').html($('#total > b').text() - 1);
         }
      });
   }
}

// Prefers color scheme
const scheme = window.matchMedia('(prefers-color-scheme: dark)')
// Local Storage
const local = localStorage.getItem('mode_activated')
// Agregamos / Cambiamos clase
const cl = document.body.classList;

cl.toggle((local === 'mode_dark_on') ? 'dark-theme' : 'light-theme')
document.getElementById('boton').addEventListener('click', () => {
   cl.toggle((scheme.matches) ? 'light-theme' : 'dark-theme')
   let mode = (scheme.matches) ? cl.contains('light-theme') ? 'mode_light_on' : 'mode_dark_on' : cl.contains('dark-theme') ? 'mode_dark_on' : 'mode_light_on'

   localStorage.setItem('mode_activated', mode)
})
