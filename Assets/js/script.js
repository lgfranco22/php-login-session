
document.getElementById("bt_login").onclick = () => {
    const dados = {
      "email": document.getElementById("email").value,
      "senha": document.getElementById("senha").value,
      "lembrar": document.getElementById("check").checked
    }
    
    const options = {
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      method: "POST",
      body: JSON.stringify(dados)
    }
  
    fetch("logarAjax.php", options)
    .then(response => {
      response.json().then(result => {
        if(result.status == 'success'){
          alert(result.message);
          window.location = 'dashboard.php';
        }
        else{
          let divMsg = document.getElementById('mensagens');
          divMsg.innerHTML = `<div class="alert alert-${result.status}">${result.message}</div>`;
        }
      })
    })
  
  
  }
  