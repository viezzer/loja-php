document.addEventListener('DOMContentLoaded', () => {
    const ordersContainer = document.getElementById('orders-container');
    const limit = 5;
    let page = 1;
    let total_pages = 0;

    async function fetchOrders(page) {
        try {
            const response = await fetch(`orderApi.php?client_name=${clientName}&limit=${limit}&page=${page}`);
            const data = await response.json();
            displayOrders(data.orders);
            total_pages = data.total_pages;
            setupPagination();
        } catch (error) {
            console.error('Error fetching orders:', error);
            ordersContainer.innerHTML = '<p>Erro ao carregar os pedidos.</p>';
        }
    }

    function displayOrders(orders) {
        if (!orders.length) {
            ordersContainer.innerHTML = '<p>Nenhum pedido encontrado</p>';
            return;
        }

        let tableHtml = `
            <table class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Quantidade em Estoque</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Fornecedor</th>
                    </tr>
                </thead>
                <tbody>
        `;

        orders.forEach(order => {
            tableHtml += `
                <tr>
                    <th scope="row">${order.id}</th>
                    <td><a href="produto.php?id=${order.id}">${order.name}</a></td>
                    <td>${order.quantity}</td>
                    <td>R$ ${order.price}</td>
                    <td>${order.supplier}</td>
                </tr>
            `;
        });

        tableHtml += '</tbody></table>';
        ordersContainer.innerHTML = tableHtml;
    }

    function setupPagination() {
        if (total_pages <= 1) return;

        let paginationHtml = '<nav><ul class="pagination">';
        paginationHtml += `<li class="page-item ${page === 1 ? 'disabled' : ''}">
                               <a class="page-link" href="#" data-page="1">Primeira</a>
                           </li>`;

        for (let i = 1; i <= total_pages; i++) {
            paginationHtml += `<li class="page-item ${i === page ? 'active' : ''}">
                                   <a class="page-link" href="#" data-page="${i}">${i}</a>
                               </li>`;
        }

        paginationHtml += `<li class="page-item ${page === total_pages ? 'disabled' : ''}">
                               <a class="page-link" href="#" data-page="${total_pages}">Última (${total_pages})</a>
                           </li>`;
        paginationHtml += '</ul></nav>';

        ordersContainer.insertAdjacentHTML('beforeend', paginationHtml);

        document.querySelectorAll('.page-link').forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault();
                page = parseInt(event.target.getAttribute('data-page'));
                fetchOrders(page);
            });
        });
    }

    fetchOrders(page);
});
