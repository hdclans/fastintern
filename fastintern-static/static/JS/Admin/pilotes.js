// Fonction pour afficher/masquer le formulaire
function toggleForm() {
    const form = document.getElementById('piloteForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Fonction pour éditer un pilote
function editPilote(id, nom, prenom, email) {
    document.getElementById('formTitle').textContent = 'Modifier un pilote';
    document.getElementById('id_utilisateur').value = id;
    document.getElementById('nom').value = nom;
    document.getElementById('prenom').value = prenom;
    document.getElementById('email').value = email;
    document.getElementById('mot_de_passe').value = '';
    
    toggleForm();
}

// Fonction pour supprimer un pilote
function deletePilote(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce pilote ?')) {
        window.location.href = `/?uri=admin_pilotes_delete&id=${id}`;
    }
}