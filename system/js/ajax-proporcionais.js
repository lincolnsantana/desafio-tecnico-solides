$('#feriasproporcionais-form').on('submit', function (event) {
    event.preventDefault();
  
    $.ajax({
      url: 'system/calcferiasproporcionais.php', // URL do arquivo PHP
      type: 'POST', // Método de solicitação
      data: $(this).serialize(),
      success: function (data) {
        $('#resultado-feriasproporcionais').html(data);
      },
      error: function () {
        $('#resultado-feriasproporcionais').html('Ocorreu um erro ao calcular.');
      }
    });
  });