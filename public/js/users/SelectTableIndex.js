document.addEventListener('DOMContentLoaded', function() {     
        
    const clients = document.getElementById('clients');
    const agents = document.getElementById('agents');
    const markets = document.getElementById('markets');
    const clientsBut = document.getElementById('clients_but');
    const agentsBut = document.getElementById('agents_but');
    const marketsBut = document.getElementById('markets_but');

    clientsBut.addEventListener('click', function(){
        clients.style.display = 'table';
        markets.style.display = 'none';
        agents.style.display = 'none';
    });

    agentsBut.addEventListener('click', function(){
        clients.style.display = 'none';
        markets.style.display = 'none';
        agents.style.display = 'table';
    });

    marketsBut.addEventListener('click', function(){
        clients.style.display = 'none';
        markets.style.display = 'table';
        agents.style.display = 'none';
    });

});