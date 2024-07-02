document.addEventListener('DOMContentLoaded', () => {
    const ordersContainer = document.getElementById('orders-container');

    async function fetchOrders() {
        try {
            const response = await fetch(`orderApi.php?client_name=${clientName}`);
            let orders = await response.json();
            orders = JSON.parse(orders);
            console.log(orders);
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
                        <th scope="col">Valor total</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
        `;

        orders.forEach(order => {
            let totalValue = 0;
            order.items.forEach(item => {
                totalValue += item.quantity * parseFloat(item.price);
            });

            tableHtml += `
                <tr>
                    <th scope="row"><a href="pedido.php?id=${order.id}">${order.number}</a></th>
                    <td>${order.orderDate}</td>
                    <td>${order.deliveryDate}</td>
                    <td>${totalValue.toFixed(2)}</td>
                    <td>${order.status}</td>
                </tr>
                <tr>
                    <td colspan="6">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Quantidade</th>
                                    <th scope="col">Valor Unitário</th>
                                    <th scope="col">Valor Total</th>
                                </tr>
                            </thead>
                            <tbody>
            `;

            order.items.forEach(item => {
                let itemTotalValue = item.quantity * parseFloat(item.price);

                tableHtml += `
                    <tr>
                        <td><img src='https://via.placeholder.com/300' alt="${item.description}" class="img-fluid" style="max-width: 300px;"></td>
                        <td>${item.product_name}</td>
                        <td>${item.quantity}</td>
                        <td>${parseFloat(item.price).toFixed(2)}</td>
                        <td>${itemTotalValue.toFixed(2)}</td>
                    </tr>
                `;
            });

            tableHtml += `
                            </tbody>
                        </table>
                    </td>
                </tr>
            `;
        });

        tableHtml += '</tbody></table>';
        ordersContainer.innerHTML = tableHtml;
    }

    fetchOrders();
});
