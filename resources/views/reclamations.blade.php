<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Réclamations</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<style>
    table {
        margin: 50px auto;
        border-collapse: collapse;
        width: 80%;
        max-width: 1000px;
        border: 1px solid #D5BDAF;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #FFFFFF;
    }

    th {
        
        color: #FFF;
        font-weight: bold;
        padding: 50px;
        text-align: center;
        border-bottom: 2px solid #EBE8D0;
    }

    td {
        padding: 40px;
        text-align: center;
        border-bottom: 1px solid #EBD8D0;
        color: #333;
    }

    tr:nth-child(even) {
        background-color:rgb(246, 246, 252);
    }

    tr:hover {
        background-color:rgb(232, 232, 240);
        transform: scale(1.01);
        transition: all 0.2s ease-in-out;
    }
    
    tr th{
        background-color:rgb(138, 138, 246);
      
    }
    .details .recentOrders table tr td a {
        text-decoration: none;
        color: #a9c174;
        font-weight: bold;
        font-size: 30px;
        margin: 0 5px;
    }

    button {
        border: none;
        color: rgb(241, 243, 237);
    }

    .details .recentOrders table tr td a:hover {
        color: #34ce39;
        text-decoration: underline;
    }

    li i {
        font-size: 2rem;
    }
    .traiterReclamation{
        background-color:#34ce39;
        padding:5px;
        border-radius:4px;
        cursor:pointer;
    }
    .traiterReclamation:hover{
        background-color:#34ce39;
    }
</style>

<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="{{ route('acceuill') }}">
                        <span class="icon"><i class='bx bx-book-reader'></i></span>
                        <span class="title">Services des étudiants</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}">
                        <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('demandes') }}">
                        <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                        <span class="title">Demandes</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reclam') }}">
                        <span class="icon"><ion-icon name="chatbubble-outline"></ion-icon></span>
                        <span class="title">Réclamations</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('historique') }}">
                        <span class="icon"><i class='bx bx-bookmark-alt'></i></span>
                        <span class="title">Historique</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}">
                        <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                        <span class="title">Déconnexion</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main">
        <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                    <input type="text" id="searchInput" placeholder="Rechercher par nom ou prénom..." onkeyup="searchTable()" />
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

            </div>

            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Les Réclamations des étudiants</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Apogée</th>
                                <th>Contenu</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="reclamationBody">
                            @foreach($reclamations as $reclamation)
                                <tr id="row_{{ $reclamation->id_reclamation }}">
                                    <td>{{ $reclamation->etudiant->nom }}</td>
                                    <td>{{ $reclamation->etudiant->prenom }}</td>
                                    <td>{{ $reclamation->etudiant->numero_apogee }}</td>
                                    <td>{{ $reclamation->contenu_reclamation }}</td>
                                    <td>{{ $reclamation->date_reclamation }}</td>
                                    <td>
                                        <button class="btn btn-success traiterReclamation" data-id="{{ $reclamation->id_reclamation }}">
                                            Traiter
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        document.querySelectorAll('.traiterReclamation').forEach(button => {
            button.addEventListener('click', function () {
                const idReclamation = this.dataset.id;

                fetch(`http://127.0.0.1:8000/reclamations/${idReclamation}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.getElementById('row_' + idReclamation);
                        if (row) row.remove();
                    } else {
                        alert(data.message || 'Erreur lors du traitement.');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur s\'est produite. Vérifiez la console.');
                });
            });
        });
    </script>
</body>

</html>
