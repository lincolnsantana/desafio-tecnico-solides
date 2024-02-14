/* esse script serve para ativar e modificar as cores dos botões da home.
tem como objetivo deixar a home mais simples e com a usabilidade mais interessante.
    esse script trabalha apenas com animações de botoes, ativando e desativando as cores das opções,
     alem de ativar ou desativar o botão "continuar" */

// armazena as divs options em uma variavel
let options = document.querySelectorAll('.option');

// adiciona um  evento 'click' a cada 'option'
options.forEach((option) => {
    option.addEventListener('click', function () {
        // quando uma 'option' é clicada, remove a classe selected de todas as options
        options.forEach((opt) => {
            opt.classList.remove('selected');
        });

        // após isso, adicionamos a classe selected à option que foi clicada
        this.classList.add('selected');
    });
});

// selecionamos o botão continuar
let continueButton = document.getElementById('continue-button');

// Inicialmente, o botao é desativado, e setado com as cores de um botão desativado.
continueButton.disabled = true;
continueButton.style.backgroundColor = '#E6E5E6';
continueButton.style.color = '#B5B0B5'

// modificamos aqui o 'click' para também ativar o botão quando uma 'option' é selecionada
options.forEach((option) => {
    option.addEventListener('click', function () {
        // quando uma option é clicada, remove a classe selected de todos os options
        options.forEach((opt) => {
            opt.classList.remove('selected');
        });

        // adicionamos a classe selected à option que foi clicada
        this.classList.add('selected');

        // ativamos o botão continuar para voltar a cor ao normal
        continueButton.disabled = false;
        continueButton.style.backgroundColor = ''; // isso irá reverter para a cor definida no CSS
        continueButton.style.color = '';
    });
});