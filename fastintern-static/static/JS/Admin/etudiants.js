// Fonction pour afficher/masquer le formulaire
function toggleForm() {
    const form = document.getElementById('etudiantForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Fonction pour éditer un étudiant
function editEtudiant(id, nom, prenom, email) {
    document.getElementById('formTitle').textContent = 'Modifier un étudiant';
    document.getElementById('id_utilisateur').value = id;
    document.getElementById('nom').value = nom;
    document.getElementById('prenom').value = prenom;
    document.getElementById('email').value = email;
    document.getElementById('mot_de_passe').value = '';
    
    toggleForm();
}

// Fonction pour supprimer un étudiant
function deleteEtudiant(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')) {
        window.location.href = `/?uri=admin_etudiants_delete&id=${id}`;
    }
}