document.addEventListener('DOMContentLoaded', () => {
    const ordersContainer = document.getElementById('orders-container');

    async function fetchOrders() {
        try {
            const response = await fetch(`orderApi.php?client_name=${clientName}`);
            let orders = await response.json();
            orders = JSON.parse(orders);
            displayOrders(orders);
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
                        <th scope="col">Numero</th>
                        <th scope="col">Data Pedido</th>
                        <th scope="col">Data Entrega</th>
                        <th scope="col">Satus</th>
                        <th scope="col">Cliente</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
        `;

        orders.forEach(order => {
            tableHtml += `
                <tr>
                    <th scope="row">${order.number}</th>
                    <td><a href="produto.php?id=${order.id}">${order.orderDate}</a></td>
                </tr>
            `;
        });

        tableHtml += '</tbody></table>';
        ordersContainer.innerHTML = tableHtml;
    }

    fetchOrders();
});
