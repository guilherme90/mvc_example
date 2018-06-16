/**
 * @author Guilherme P. Nogueira <guilhermenogueira@univicosa.com.br>
 */

var UserGroup = function() {
  
  this.remove = function(userGroupId) {
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
            url: '/groups/removeUserGroup',
            method: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
              userGroupId: userGroupId
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

window.UserGroup = new UserGroup();
