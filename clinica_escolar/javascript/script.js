// Aqui espero o carregamento completo do HTML antes de correr o JavaScript
document.addEventListener('DOMContentLoaded', () => {

  // Aqui busco os elementos do HTML pelos seus IDs
  const medicoSelect   = document.getElementById('medico');
  const dataInput      = document.getElementById('data');
  const slotsDiv       = document.getElementById('slots');
  const btnConfirmar   = document.getElementById('btnConfirmar');
  const msgErro        = document.getElementById('mensagem');
  const msgSucesso     = document.getElementById('mensagemSucesso');

  // Aqui guardo o horário selecionado pelo utilizador
  let slotSelecionado = null;

  // Aqui defino a data mínima para o input de data para não marcar no passado
  const hoje = new Date();
  const ano  = hoje.getFullYear();
  const mes  = String(hoje.getMonth() + 1).padStart(2, '0');
  const dia  = String(hoje.getDate()).padStart(2, '0');
  const hojeStr = `${ano}-${mes}-${dia}`;

  // Aqui defino no input de data o mínimo permitido como sendo a data de hoje
  dataInput.min = hojeStr;

  // Se ainda não tiver valor, coloco a data de hoje automaticamente apenas para segurança
  if (!dataInput.value) {
    dataInput.value = hojeStr;
  }

  // Apenas logs para ver no console o valor inicial
  console.log('Valor inicial do médico:', medicoSelect.value);
  console.log('Valor inicial da data:', dataInput.value);

  // Função que vai carregar os horários disponíveis do servidor, api_horarios
  async function carregarHorarios() {
    // Aqui limpo os slots e escondo mensagens
    slotsDiv.innerHTML = 'Carregando horários...';
    msgErro.style.display = 'none';
    msgSucesso.style.display = 'none';
    slotSelecionado = null;

    // Aqui leio o médico selecionado e a data escolhida
    const medicoId = (medicoSelect.value || '').trim();
    const data     = (dataInput.value   || '').trim();

    console.log('Chamando API com:', { medicoId, data });

    // Se faltar médico ou data, não chamo a API
    if (!medicoId || !data) {
      slotsDiv.innerHTML = 'Selecione médico e data.';
      console.warn('Não vou chamar API: parâmetros vazios.');
      return;
    }

    try {
      // Aqui construo a URL da API com os parâmetros
      const url = `api/api_horarios.php?medico_id=${encodeURIComponent(medicoId)}&data=${encodeURIComponent(data)}`;
      console.log('URL chamada:', url);

      // Aqui faço o pedido à API
      const resposta = await fetch(url);

      // Aqui leio a resposta como texto primeiro (para teste)
      const texto = await resposta.text();
      console.log('Resposta bruta da API:', texto);

      // Se a resposta não for ok, lanço erro
      if (!resposta.ok) {
        throw new Error('Erro na requisição: ' + resposta.status);
      }

      let horarios;
      try {
        // Aqui converto o texto para JSON
        horarios = JSON.parse(texto);
      } catch (e) {
        console.error('Erro ao fazer JSON.parse:', e);
        throw e;
      }

      // Limpo os horários anteriores
      slotsDiv.innerHTML = '';

      // Se não vier nenhum horário desse dia
      if (!Array.isArray(horarios) || horarios.length === 0) {
        slotsDiv.innerHTML = 'Nenhum horário cadastrado para este dia.';
        return;
      }

      // Aqui percorro cada horário devolvido pela api_horarios com o forEach
      horarios.forEach(h => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.classList.add('slot');
        // Mostro apenas HH:MM
        btn.textContent = h.hora.substring(0, 5);

        // Se estiver disponível (1), crio um botão clicável
        if (parseInt(h.disponivel) === 1) {
          btn.classList.add('disponivel');

          // Aqui defino o que acontece quando o utilizador clica num horário
          btn.addEventListener('click', () => {
            // Remove a seleção de outros botões
            document.querySelectorAll('.slot.selecionado')
                    .forEach(el => el.classList.remove('selecionado'));

            // Marca este como selecionado
            btn.classList.add('selecionado');

            // Guarda o horário escolhido nesta variável
            slotSelecionado = {
              id: h.id,
              hora: h.hora
            };
          });
        } else {
          // Se não estiver disponível, marco como ocupado e desativo o botão
          btn.classList.add('ocupado');
          btn.disabled = true;
        }

        // Adiciono o botão ao container dos horários
        slotsDiv.appendChild(btn);
      });

    } catch (erro) {
      console.error('Erro em carregarHorarios:', erro);
      slotsDiv.innerHTML = 'Erro ao carregar horários.';
    }
  }

  // Aqui valido e confirmo a marcação quando o utilizador clica no botão "Confirmar agendamento"
  btnConfirmar.addEventListener('click', async () => {
    // Escondo mensagens anteriores
    msgErro.style.display = 'none';
    msgSucesso.style.display = 'none';

    // Leio os valores atuais
    const medicoId   = (medicoSelect.value || '').trim();
    const data       = (dataInput.value   || '').trim();
    const medicoNome = medicoSelect.options[medicoSelect.selectedIndex].text;

    // Verifico se o médico foi selecionado
    if (!medicoId) {
      msgErro.textContent = 'Selecione um médico.';
      msgErro.style.display = 'block';
      return;
    }

    // Verifico se foi escolhida uma data
    if (!data) {
      msgErro.textContent = 'Selecione uma data.';
      msgErro.style.display = 'block';
      return;
    }

    // Verifico se a data não é uma data passada
    if (data < hojeStr) {
      msgErro.textContent = 'Não é permitido agendar datas passadas.';
      msgErro.style.display = 'block';
      return;
    }

    // Verifico se o utilizador escolheu um horário
    if (!slotSelecionado) {
      msgErro.textContent = 'Selecione um horário disponível.';
      msgErro.style.display = 'block';
      return;
    }

    try {
      // Aqui envio os dados da marcação para o PHP em JSON
      const resp = await fetch('api/marcar_consulta.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          medico_id: medicoId,
          data: data,
          hora: slotSelecionado.hora
        })
      });

      // Aqui leio a resposta como JSON
      const json = await resp.json();

      // Se o PHP devolver erro, mostro a mensagem
      if (!json.ok) {
        msgErro.textContent = json.msg || 'Erro ao marcar consulta.';
        msgErro.style.display = 'block';
        return;
      }

      // Se deu tudo certo, mostro mensagem de sucesso
      msgSucesso.textContent = json.msg;
      msgSucesso.style.display = 'block';

    } catch (e) {
      console.error(e);
      msgErro.textContent = 'Erro de comunicação com o servidor.';
      msgErro.style.display = 'block';
      // Tento recarregar os horários em caso de problema para segurança
      carregarHorarios();
    }
  });

  // Sempre que o médico for alterado, recarrego os horários
  medicoSelect.addEventListener('change', carregarHorarios);

  // Sempre que a data for alterada, recarrego os horários
  dataInput.addEventListener('change', carregarHorarios);

  // Quando a página é carregada, já chamo a função para mostrar horários iniciais
  carregarHorarios();
});
