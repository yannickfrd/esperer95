export class User {

    baseUrl = "https://127.0.0.1:8000";


    delete(id) {
        const url = this.baseUrl + '/delete-user/' + id;
        const headers = () => {
          const h = new Headers();
          h.append('Content-Type', 'application/json');
          return h;
        }

        const option = {
            method: 'DELETE',
            headers: headers()
        }
        fetch(new Request(url, option))
            .then(response => response.json())
            .then(() => location.reload())
    }
}
