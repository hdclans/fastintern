function toggleForm() {
    const form = document.getElementById('piloteForm');
    const formTitle = document.getElementById('formTitle');
    const passwordInfo = document.getElementById('password-info');

    if (form.style.display === 'none') {
        form.style.display = 'block';
        formTitle.innerText = 'Créer un nouveau pilote';
        
        // Réinitialiser le formulaire
        document.querySelector('#piloteForm form').reset();
        document.getElementById('id_utilisateur').value = '';
        document.getElementById('id_role').value = '2'; // Par défaut, pilote
        
        // Le mot de passe est obligatoire pour un nouveau pilote
        document.getElementById('mot_de_passe').required = true;
        passwordInfo.style.display = 'none';
    } else {
        form.style.display = 'none';
    }
}

function editPilote(id, nom, prenom, email, id_role) {
    // Remplir le formulaire avec les valeurs existantes
    document.getElementById('id_utilisateur').value = id;
    document.getElementById('nom').value = nom;
    document.getElementById('prenom').value = prenom;
    document.getElementById('email').value = email;
    document.getElementById('id_role').value = id_role;
    
    // Le mot de passe n'est pas obligatoire lors de la modification
    document.getElementById('mot_de_passe').required = false;
    document.getElementById('password-info').style.display = 'inline';
    
    // Changer le titre du formulaire
    document.getElementById('formTitle').innerText = 'Modifier un pilote';
    
    // Afficher le formulaire
    document.getElementById('piloteForm').style.display = 'block';
    
    // Défiler jusqu'au formulaire
    document.getElementById('piloteForm').scrollIntoView({ behavior: 'smooth' });
}

function deletePilote(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        window.location.href = `/?uri=admin/pilotes/delete&id=${id}`;
    }
}