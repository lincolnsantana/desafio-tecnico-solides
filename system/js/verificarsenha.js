document.getElementById('senha').addEventListener('keyup', verificarSenhas);
document.getElementById('repetir-senha').addEventListener('keyup', verificarSenhas);

  function verificarSenhas() {
    var senha = document.getElementById('senha');
    var repetirSenha = document.getElementById('repetir-senha');
    var mensagemErro = document.getElementById('repetir-senha-error');

    if (senha.value && repetirSenha.value) {
      if (senha.value === repetirSenha.value) {
        senha.style.borderColor = 'green';
        repetirSenha.style.borderColor = 'green';
        mensagemErro.style.display = 'none';
      } else {
        senha.style.borderColor = 'red';
        repetirSenha.style.borderColor = 'red';
        mensagemErro.style.display = 'block';
      }
    } else {
      senha.style.borderColor = '';
      repetirSenha.style.borderColor = '';
      senha.style.borderWidth = '';
      repetirSenha.style.borderWidth = '';
      mensagemErro.style.display = 'none';
    }
  }