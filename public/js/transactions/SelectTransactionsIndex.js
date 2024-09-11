document.addEventListener('DOMContentLoaded', function(){
    const await = document.getElementById('await');
    const success = document.getElementById('success');
    const archive = document.getElementById('archive');
    const dispute = document.getElementById('dispute');
    const await_but = document.getElementById('await_but');
    const archive_but = document.getElementById('archive_but');
    const success_but = document.getElementById('success_but');
    const dispute_but = document.getElementById('dispute_but');

    await_but.addEventListener('click', function(){
        await.style.display = 'table';
        archive.style.display = 'none';
        success.style.display = 'none';
        dispute.style.display = 'none';
    })
    archive_but.addEventListener('click', function(){
        await.style.display = 'none';
        archive.style.display = 'table';
        success.style.display = 'none';
        dispute.style.display = 'none';
    })
    success_but.addEventListener('click', function(){
        archive.style.display = 'none';
        success.style.display = 'table';
        await.style.display = 'none';
        dispute.style.display = 'none';
    })
    dispute_but.addEventListener('click', function(){
        archive.style.display = 'none';
        success.style.display = 'none';
        await.style.display = 'none';
        dispute.style.display = 'table';
    })


})