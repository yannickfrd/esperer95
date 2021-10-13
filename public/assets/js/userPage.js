import {User} from './user.js'

function instanceUser() {
    let user = new User();
    user.delete(this.getAttribute('data-id'));
}

document.querySelector('a.btn-delete').addEventListener('click', instanceUser)
