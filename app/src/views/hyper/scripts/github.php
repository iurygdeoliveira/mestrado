<script>
/*
    O Algoritmo é uma função assíncrona chamada "executeRequest",
    responsável por efetuar uma requisição GET na API do GitHub.
    Na linha 1 a  função aguarda a importação de um SDK do GitHub
    e depois chama o método "request" desse SDK, passando os
    parâmetros necessários para a requisição, incluindo o URL
    da API, o token de autorização e o caminho do arquivo que se
    deseja obter. O objetivo do algoritmo é fazer a busca de
    informações de arquivos no repositório do Github
    automatizadamente, utilizando uma token de acesso para se
    obter autorização para efetuar a busca.
    */
async function executeRequest(path) {

    let github = await import('https://cdn.skypack.dev/@octokit/request');

    return await github.request({
        method: "GET",
        url: '/repos/{owner}/{repo}/contents/{path}',
        headers: {
            authorization: 'SEU TOKEN DE ACESSO',
        },
        owner: "iurygdeoliveira",
        repo: "cyclevis_dataset",
        path: path
    });

    /*
    Na esfera do desenvolvimento de software e sistemas web, um
    "token de acesso" é um elemento crítico no que diz respeito
    à autenticação e autorização de usuários e aplicativos. Esse
    token, que é uma sequência alfanumérica, atua como uma
    credencial que permite o acesso a recursos específicos.
    No caso particular da API do GitHub, existem dois tipos
    principais de tokens de acesso: o "Personal Access Token"
    e o "User Access Token" do GitHub App.

    A principal função desses tokens é autenticar usuários
    e aplicativos sem a necessidade de utilizar uma senha.
    Assim, um token de acesso é gerado por um usuário e pode
    ser atribuído diferentes níveis de permissões, permitindo
    que o usuário controle quais aspectos de sua conta no
    GitHub podem ser acessados por meio desse token.

    No entanto, é fundamental ressaltar a necessidade de
    tratar um token de acesso com o mesmo nível de segurança
    que uma senha. Isso ocorre porque a posse de um token de
    acesso confere ao portador os mesmos níveis de acesso
    atribuídos ao token no momento de sua criação. Portanto,
    os tokens de acesso são comumente utilizados em contextos
    onde a autenticação segura é necessária sem expor a senha
    do usuário.

    No contexto do estudo realizado com a aplicação Cyclevis,
    por questões de segurança, o token de acesso utilizado não
    foi divulgado. No entanto, qualquer pesquisador que deseje
    reproduzir ou expandir o estudo pode substituir
    <SEU TOKEN DE ACESSO> pelo seu próprio token de acesso.
    Para instruções mais detalhadas sobre como gerar e gerenciar
    tokens de acesso, bem como sobre o uso do pacote Octokit.js
    para interação com a API do GitHub, os pesquisadores
    são encorajados a consultar a documentação oficial do Octokit.js
    Disponível em: https://docs.github.com/pt/rest/quickstart
    ?apiVersion=2022-11-28\&tool=javascript Acessado em 28/06/2023
    e a página de gerenciamento de tokens de acesso Disponível em:
    https://docs.github.com/pt/authentication/keeping-your-
    account-and-data-secure/managing-your-personal-access-tokens
    Acessado em 28/06/2023 do GitHub
     */

}



async function getDataGithub(path) {

    return await executeRequest(path);
}

async function getDistancesGithub(cyclist) {

    let pathCyclist = "Cyclist_" + cyclist.replace(/[^0-9]/g, '');

    let response = await getDataGithub(pathCyclist + '/all_distances.json');
    let distances_url = response.data.download_url;

    let data = await d3.json(distances_url,
        data => {
            return data
        }
    );

    let distances_current = data.all_distances.split("|");
    distances_current = distances_current.map((element) => {
        let aux = element.split(",");
        let distanceAux = aux[0].split(":");
        let id = aux[1].split(":");
        let data = {
            'distance': parseFloat(distanceAux[1]),
            'id': parseFloat(id[1])
        };
        return data;
    });
    return distances_current;
}

function extractUrlDownload(arr, value) {

    let element = arr.filter(function(ele) {
        return ele.name === value;
    });

    return element[0].download_url;
}

async function getPedaladaGithub(cyclist, pedalada) {

    let pathCyclist = "Cyclist_" + cyclist.replace(/[^0-9]/g, '') + '/';

    let pedal = pedalada.split("_");
    pedal = pedal[2];

    let response = await getDataGithub(pathCyclist + 'pedal' + pedal);

    let urls = [
        extractUrlDownload(response.data, 'distance_history.json'),
        extractUrlDownload(response.data, 'elevation_google.json'),
        extractUrlDownload(response.data, 'heartrate_history.json'),
        extractUrlDownload(response.data, 'speed_history.json'),
        extractUrlDownload(response.data, 'time_history.json'),
        extractUrlDownload(response.data, 'latitudes.json'),
        extractUrlDownload(response.data, 'longitudes.json'),
        extractUrlDownload(response.data, 'overview.json'),
    ];

    const promises = urls.map(async (url_current, idx) => {
        return await d3.json(url_current,
            data => {
                return data
            }
        );
    });

    return await Promise.all(promises);
}
</script>