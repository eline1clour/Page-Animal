<?php

interface AnimalStorage {
    /**
     * Fonction pour lire un animal dans la base
     * 
     * @param string $id l'identifiant de l'animal lu
     * @return Animal une instance de animal si identifiant existe et null sinon
     */
    public function read(String $id);

    /**
     * Fonction pour lire tous les animaux de la base
     * 
     * @return array tableau associatif contenant tous les animaux de la base
     */
    public function readAll();

    /**
     * Fonction pour ajouter un animal à la base.
     * 
     * @param Animal $a l'animal à ajouter.
     * @return string l'identifiant unique attribué à l'animal crée.
     */
    public function create(Animal $a);
    
    /** 
     * Fonction pour supprimer un animal de la base
     * 
     * @param string $id l'identifiant de l'animal à supprimer
     * @return bool true si la suppression est réussi et false sinon   
    */
    public function delete(String $id);

    /**
     * Fonction pour mettre à jour un animal de la base
     * 
     * @param string $id l'identifiant de l'animal qu'on met à jour
     * @param Animal $a l'animal de remplacement
     * @return bool true si la mise à jour est réussi et false si l'identifiant n'existe pas
     */
    public function update(String $id, Animal $a);
}