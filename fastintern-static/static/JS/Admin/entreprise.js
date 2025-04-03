// Fonction pour afficher ou masquer le formulaire
function toggleForm() {
    const form = document.getElementById('entrepriseForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Fonction pour pré-remplir le formulaire lors de la modification d'une entreprise
function editEntreprise(id, nom, description, email, telephone, adresse) {
    document.getElementById('formTitle').textContent = 'Modifier une entreprise';
    document.getElementById('id_entreprise').value = id;
    document.getElementById('nom_entreprise').value = nom;
    document.getElementById('description').value = description;
    document.getElementById('email_contact').value = email;
    document.getElementById('telephone_contact').value = telephone;
    document.getElementById('adresse').value = adresse;
    toggleForm();
}

// Fonction pour confirmer la suppression d'une entreprise
function deleteEntreprise(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?')) {
        window.location.href = `/?uri=admin/entreprises/delete&id=${id}`;
    }
}
