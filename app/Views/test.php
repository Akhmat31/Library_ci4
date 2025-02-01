<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API tes</title>
</head>
<body>
    <h1>Data dari API</h1>
    <div id="api-data"></div>
    <script>
        const url = 'http://localhost:8080/permission/erly-access/api/version/v1';
        async function fetchData() {
            try {
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) {
                    throw new Error(`Error: ${response.status}`);
                }
                const data = await response.json();
                console.log(data);
                const apiDataDiv = document.getElementById('api-data');
                let output = '<ul>';

                data.forEach(item => {
                    output += `<li>${item.nama}: ${item.deskripsi}</li>`; 
                });
                output += '</ul>';
                apiDataDiv.innerHTML = output;
            } catch (error) {
                console.error('Error fetching the data:', error);
            }
        }
        fetchData();
    </script>
</body>
</html>