/* esse ajax mostra o resultado dos calculos de salário na mesma pagina que é efetuada o preenchimento de dados */

$('#diasuteis-form').on('submit', function (event) {
    event.preventDefault();
  
    $.ajax({
      url: 'system/calcferias-diasuteis.php', // URL do arquivo PHP
      type: 'POST', // Método de solicitação
      data: $(this).serialize(),
      success: function (data) {
        $('#resultado-diasuteis').html(data);
      },
      error: function () {
        $('#resultado-diasuteis').html('Ocorreu um erro ao calcular o salário.');
      }
    });
  });
