function toggleForm() {
    const form = document.getElementById('adminForm');
    const formTitle = document.getElementById('formTitle');
    const passwordInfo = document.getElementById('password-info');

    if (form.style.display === 'none') {
        form.style.display = 'block';
        formTitle.innerText = 'Créer un nouvel administrateur';
        
        // Réinitialiser le formulaire
        document.querySelector('#adminForm form').reset();
        document.getElementById('id_utilisateur').value = '';
        document.getElementById('id_role').value = '1'; // Assure que le rôle est bien "administrateur"
        
        // Le mot de passe est obligatoire pour un nouvel administrateur
        document.getElementById('mot_de_passe').required = true;
        passwordInfo.style.display = 'none';
    } else {
        form.style.display = 'none';
    }
}

function editAdmin(id, nom, prenom, email) {
    // Remplir le formulaire avec les valeurs existantes
    document.getElementById('id_utilisateur').value = id;
    document.getElementById('nom').value = nom;
    document.getElementById('prenom').value = prenom;
    document.getElementById('email').value = email;
    document.getElementById('id_role').value = '1'; // Assure que le rôle reste "administrateur"
    
    // Le mot de passe n'est pas obligatoire lors de la modification
    document.getElementById('mot_de_passe').required = false;
    document.getElementById('password-info').style.display = 'inline';
    
    // Changer le titre du formulaire
    document.getElementById('formTitle').innerText = 'Modifier un administrateur';
    
    // Afficher le formulaire
    document.getElementById('adminForm').style.display = 'block';
    
    // Défiler jusqu'au formulaire
    document.getElementById('adminForm').scrollIntoView({ behavior: 'smooth' });
}

function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?')) {
        window.location.href = `/?uri=admin/admins/delete&id=${id}`;
    }
}