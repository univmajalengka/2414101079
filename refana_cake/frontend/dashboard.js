function prepareCakeModal(mode, id = 0) {
    const modalTitle = document.getElementById('cakeModalLabel');
    const submitBtn = document.getElementById('modal-submit-btn');
    const cakeForm = document.getElementById('cake-form'); 
    
    document.getElementById('modal-name').value = '';
    document.getElementById('modal-description').value = '';
    document.getElementById('modal-price').value = '';
    document.getElementById('modal-stock').value = '';
    document.getElementById('modal-image-path').value = 'assets/images/default.jpg';
    document.getElementById('modal-mode').value = mode;
    document.getElementById('modal-cake-id').value = id;

    if (mode === 'add') {
        modalTitle.textContent = 'Tambah Kue Baru';
        submitBtn.textContent = 'Simpan Kue';
        cakeForm.action = 'crud/add_cake.php'; 
    } else if (mode === 'edit') {
        const row = document.getElementById('cake-row-' + id);
        if (!row) return;
        
        modalTitle.textContent = 'Edit Kue';
        submitBtn.textContent = 'Perbarui Kue';
        cakeForm.action = 'crud/edit_cake.php';

        const name = row.querySelector('td:nth-child(3)').getAttribute('data-name');
        const desc = row.querySelector('td:nth-child(3)').getAttribute('data-desc');
        const cells = row.querySelectorAll('td');
        const price = cells[4].getAttribute('data-price'); 
        const stock = cells[4].getAttribute('data-stock');
        const path = cells[4].getAttribute('data-path');
        
        document.getElementById('modal-name').value = name;
        document.getElementById('modal-description').value = desc;
        document.getElementById('modal-price').value = price;
        document.getElementById('modal-stock').value = stock;
        document.getElementById('modal-image-path').value = path;
    }
}

function showOrderDetail(id) {
    const row = document.getElementById('order-row-' + id);
    if (!row) return;

    const customer = row.getAttribute('data-customer');
    const date = row.getAttribute('data-date');
    const total = row.getAttribute('data-total');
    const address = row.getAttribute('data-address');
    const items = row.getAttribute('data-items').replace(/, /g, '\n'); 
    const status = row.getAttribute('data-status');
    const statusBadge = row.querySelector('.badge');

    document.getElementById('detail-order-id').textContent = id;
    document.getElementById('detail-customer').textContent = customer;
    document.getElementById('detail-date').textContent = date;
    document.getElementById('detail-address').textContent = address;
    document.getElementById('detail-items').textContent = items;
    document.getElementById('detail-total').textContent = total;
    
    const detailStatusEl = document.getElementById('detail-status');
    detailStatusEl.textContent = status;
    detailStatusEl.className = statusBadge.className; 
}

function showChangeStatus(id, currentStatus) {
    document.getElementById('status-order-id').textContent = id;
    document.getElementById('status-order-id-input').value = id;
    document.getElementById('current-status').textContent = currentStatus;

    const selectEl = document.getElementById('new_status');
    selectEl.value = currentStatus;
}