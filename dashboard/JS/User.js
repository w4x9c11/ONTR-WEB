document.addEventListener('DOMContentLoaded', function () {
    const pageLoader = document.createElement('div');
    pageLoader.className = 'page-loader';
    pageLoader.innerHTML = `
        <svg class="loader-svg" viewBox="0 0 50 50">
            <circle class="loader-circle" cx="25" cy="25" r="20"/>
        </svg>
    `;
    document.body.appendChild(pageLoader);

    setTimeout(() => {
        pageLoader.classList.add('hide');
    }, 500);

    const infoCards = document.querySelectorAll('.info-card');
    infoCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 * index);
    });

    const subscriptionItems = document.querySelectorAll('.subscription-item');
    subscriptionItems.forEach((item, index) => {
        setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, 150 * index);
    });
});

function formatDateTime(timestamp) {
    const date = new Date(timestamp * 1000);
    return date.toLocaleString();
}

function downloadSoftware() {
    // 这里添加下载逻辑
    const downloadUrl = 'path/to/your/software.zip'; // 替换为实际的下载链接

    // 创建一个隐藏的a标签来触发下载
    const link = document.createElement('a');
    link.href = downloadUrl;
    link.download = 'ONTR-v1.0.zip'; // 设置下载文件名
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    // 显示下载开始通知
    window.notification.showSuccess();
}