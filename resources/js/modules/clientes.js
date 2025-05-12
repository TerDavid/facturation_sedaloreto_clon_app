import { getBienvenida } from "../api/clientes.api";

document.addEventListener('DOMContentLoaded', () => {
    if (document.body.classList.contains('home-page')) {
        // código para home
        console.log('Home page script');
    }

    if (document.body.classList.contains('gestion_clientes')) {
        // código para dashboard
        console.log('Dashboard script');
        getBienvenida().then(response => {
            console.log('Mensaje:', response.data);
        });
    }
});
