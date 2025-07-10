document.addEventListener('DOMContentLoaded', function() {
    const regenerateButton = document.getElementById('regenerateApiKey');

    if (!regenerateButton) {
        return;
    }

    regenerateButton.addEventListener('click', async function() {
        if (!confirm('Вы уверены что хотите сгенерировать новый ключ?')) {
            return;
        }

        const url = this.dataset.url;

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
            });

            const data = await response.json();

            if (data.success) {
                document.querySelector('.api_key_input').value = data.newApiKey;
                showFlashMessage('API ключ успешно обновлён!', 'success');
            } else {
                throw new Error('Не удалось обновить API ключ');
            }

        } catch (e) {
            console.error(e);
        }
    });

    function showFlashMessage(message, type = 'success') {
        // Удаляем предыдущие сообщения
        const existingAlerts = document.querySelectorAll('.flash-message');
        existingAlerts.forEach(alert => alert.remove());

        // Создаем новое сообщение
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} flash-message mt-3`;
        alert.textContent = message;

        // Вставляем после формы
        const form = document.querySelector('form');
        if (form) {
            form.after(alert);

            // Автоматическое скрытие через 5 секунд
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }
    }
});
