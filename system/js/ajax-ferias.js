/* esse ajax mostra o resultado dos calculos de salário na mesma pagina que é efetuada o preenchimento de dados */

$('#ferias-form').on('submit', function (event) {
    event.preventDefault();
  
    $.ajax({
      url: 'system/calcferias.php', // URL do arquivo PHP
      type: 'POST', // Método de solicitação
      data: $(this).serialize(),
      success: function (data) {
        $('#resultado-ferias').html(data);
      },
      error: function () {
        $('#resultado-ferias').html('Ocorreu um erro ao calcular o salário.');
      }
    });
  });
