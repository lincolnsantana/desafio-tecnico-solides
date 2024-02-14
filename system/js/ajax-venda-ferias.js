/* esse ajax mostra o resultado dos calculos de salário na mesma pagina que é efetuada o preenchimento de dados */

$('#vendaferias-form').on('submit', function (event) {
    event.preventDefault();
  
    $.ajax({
      url: 'system/calcvendaferias.php', // URL do arquivo PHP
      type: 'POST', // Método de solicitação
      data: $(this).serialize(),
      success: function (data) {
        $('#resultado-vendaferias').html(data);
      },
      error: function () {
        $('#resultado-vendaferias').html('Ocorreu um erro ao calcular o salário.');
      }
    });
  });
