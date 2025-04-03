function toggleForm() {
    const form = document.getElementById('etudiantForm');
    const formTitle = document.getElementById('formTitle');
    const passwordInfo = document.getElementById('password-info');

    if (form.style.display === 'none') {
        form.style.display = 'block';
        formTitle.innerText = 'Créer un nouvel étudiant';
        
        // Réinitialiser le formulaire
        document.querySelector('#etudiantForm form').reset();
        document.getElementById('id_utilisateur').value = '';
        document.getElementById('id_role').value = '3'; // Assure que le rôle est bien "étudiant"
        
        // Le mot de passe est obligatoire pour un nouvel étudiant
        document.getElementById('mot_de_passe').required = true;
        passwordInfo.style.display = 'none';
    } else {
        form.style.display = 'none';
    }
}

function editEtudiant(id, nom, prenom, email) {
    // Remplir le formulaire avec les valeurs existantes
    document.getElementById('id_utilisateur').value = id;
    document.getElementById('nom').value = nom;
    document.getElementById('prenom').value = prenom;
    document.getElementById('email').value = email;
    document.getElementById('id_role').value = '3'; // Assure que le rôle reste "étudiant"
    
    // Le mot de passe n'est pas obligatoire lors de la modification
    document.getElementById('mot_de_passe').required = false;
    document.getElementById('password-info').style.display = 'inline';
    
    // Changer le titre du formulaire
    document.getElementById('formTitle').innerText = 'Modifier un étudiant';
    
    // Afficher le formulaire
    document.getElementById('etudiantForm').style.display = 'block';
    
    // Défiler jusqu'au formulaire
    document.getElementById('etudiantForm').scrollIntoView({ behavior: 'smooth' });
}

function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')) {
        window.location.href = `/?uri=admin/etudiants/delete&id=${id}`;
    }
}