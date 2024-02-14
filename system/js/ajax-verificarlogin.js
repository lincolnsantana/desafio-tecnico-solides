$('#login-form').on('submit', function (event) {
    event.preventDefault();
  
    $.ajax({
      url: 'system/verificar-login.php', // URL do arquivo PHP
      type: 'POST', // Método de solicitação
      data: $(this).serialize(),
      success: function (data) {
        $('#verifica-login').html(data);
      },
      error: function () {
        $('#verifica-login').html('Ocorreu um erro ao calcular.');
      }
    });
  });