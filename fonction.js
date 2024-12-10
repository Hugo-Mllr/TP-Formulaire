
// Récupérer la date actuelle
const today = new Date();
// Formater la date au format DD/MM/YYYY
const day = today.getDate().toString().padStart(2, '0'); // Ajouter un zéro devant si nécessaire
const month = (today.getMonth() + 1).toString().padStart(2, '0'); // Les mois vont de 0 à 11, donc on ajoute 1
const year = today.getFullYear();
const formattedDate = `${day}/${month}/${year}`;
// Remplir le champ de date
document.getElementById('contrat_date_jour').value = formattedDate;





