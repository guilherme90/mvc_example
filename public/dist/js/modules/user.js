/**
 * @author Guilherme P. Nogueira <guilhermenogueira@univicosa.com.br>
 */

var User = function() {
  
  /**
   * @param {Object} data
   * @returns Object|undefined
   */
  this.validateForm = function(data) {
    var constraints = {
      name: {
        presence: true,
        length: {
          minimum: 3,
          maximum: 50,
          message: 'O campo "nome" deve conter no mínimo 3 e no máximo 50 caracteres'
        }
      },
      last_name: {
        presence: true,
        length: {
          minimum: 3,
          maximum: 50,
          message: 'O campo "sobrenome" deve conter no mínimo 3 e no máximo 100 caracteres'
        }
      },
      groups: {
        presence: true,
        length: {
          minimum: 2,
          tooShort: 'Informe no mínimo 2 grupos'
        }
      }
    };
    
    return validate(data, constraints, {
      format: 'flat',
      fullMessages: false
    });
  }
  
  this.add = function() {
    var button = document.querySelector('button[name=btn-add-user]');
    var alertMessage = document.querySelector('#alert-message');

    alertMessage.classList.add('hidden');
    alertMessage.innerHTML = '';

    button.setAttribute('disabled', 'disabled');

    var data = {
      name: $('#name').val(),
      last_name: $('#last_name').val(),
      groups: $('#groups').val() || []
    }
    
    var validator = this.validateForm(data);
    
    if (validator !== undefined) {
      var errorMessage = '';
      validator.map(function(message) {
        errorMessage += '<p>' + message + '</p>';
      })
  
      alertMessage.classList.remove('hidden');
      alertMessage.innerHTML = errorMessage
      
      return;
    }
    
    $.ajax({
      url: '/users/add',
      method: 'POST',
      dataType: 'json',
      contentType: 'application/json',
      data: JSON.stringify(data)
    }).done((function (payload) {
      button.removeAttribute('disabled');

      if (! payload.success) {
        alertMessage.classList.remove('hidden');
        alertMessage.innerHTML = payload.message;
      }

      if (payload.success) {
        window.location.href = '/users';
      }
    }));
  }
  
  /**
   * @param {String} userId
   */
  this.edit = function(userId) {
    var button = document.querySelector('button[name=btn-add-user]');
    var alertMessage = document.querySelector('#alert-message');

    alertMessage.classList.add('hidden');
    alertMessage.innerHTML = '';

    button.setAttribute('disabled', 'disabled');

    $.ajax({
      url: '/users/edit/?id=' + userId,
      method: 'POST',
      dataType: 'json',
      contentType: 'application/json',
      data: JSON.stringify({
        name: $('#name').val(),
        last_name: $('#last_name').val(),
        groups: $('#groups').val() || []
      })
    }).done((function (payload) {
      button.removeAttribute('disabled');

      if (! payload.success) {
        alertMessage.classList.remove('hidden');
        alertMessage.innerHTML = payload.message;
      }

      if (payload.success) {
        window.location.href = '/users';
      }
    }));
  }
  
  /**
   * @param {String} userId
   */
  this.remove = function(userId) {
    bootbox.confirm({
      title: 'Confirmação',
      message: 'Você está querendo remover esse registro, no entanto não será possível recuperá-lo.',
      buttons: {
        cancel: {
          label: '<i class="glyphicon glyphicon-remove"></i> Não'
        },
        confirm: {
          label: '<i class="glyphicon glyphicon-trash"></i> Sim'
        }
      },
      callback: function (result) {
        if (result) {
          $.ajax({
            url: '/users/remove',
            method: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
              userId: userId
            })
          }).done((function (payload) {
            if (payload.success) {
              window.location.reload(true);
            }
          }));
        }
      }
    });
  }
}

window.User = new User();
