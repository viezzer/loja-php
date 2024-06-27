document.addEventListener('DOMContentLoaded', () => {
    const ordersContainer = document.getElementById('orders-container');

    async function fetchOrders() {
        try {
            const response = await fetch(`orderApi.php?client_name=${clientName}`);
            let orders = await response.json();
            orders = JSON.parse(orders);
            console.log(orders)
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
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
        `;

        orders.forEach(order => {
            tableHtml += `
                <tr>
                    <th scope="row"><a href="produto.php?id=${order.id}">${order.number}</a></th>
                    <td>${order.orderDate}</td>
                    <td>${order.deliveryDate}</td>
                    <td>${order.status}</td>
                    </tr>
            `;
        });

        tableHtml += '</tbody></table>';
        ordersContainer.innerHTML = tableHtml;
    }

    fetchOrders();
});
