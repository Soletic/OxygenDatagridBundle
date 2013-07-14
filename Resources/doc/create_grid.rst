Afficher un DataGrid
====================

Déclarer un Datagrid
--------------------

L'affichage d'un Datagrid commence d'abord par le déclarer en créant un service taggé par oxygen.grid.configuration
et précisant :

* La classe de configuration
* Un identifiant unique
* Le type source (entity uniquement disponible actuellement)
* La référence de la source : 

   * soit une classe entité : MyBundle\Entity\Event
   * soit l'identifiant d'une entité déclarée :doc:`Lire la documentation de OxygenFrameworkBundle <https://github.com/Soletic/OxygenFrameworkBundle/blob/master/Resources/doc/entity_override_manager.rst>` 
   
.. code-block:: xml

   <service id="my_service_configuration" class="Oxygen\DatagridBundle\Grid\Configuration\SimpleListConfiguration">
      <tag name="oxygen.grid.configuration" 
         grid_id="oxygen_passbook_event" 
         source_type="entity" source_reference="oxygen_passbook.event" />
   </service>

OxygenDatagridBundle fournit un jeu de classes de configuration prêt à l'emploi.

Ici nous utilisons Oxygen\DatagridBundle\Grid\Configuration\SimpleListConfiguration listant la source de données
sans filtres de recherche, sans possibilité de tris.

Afficher le Datagrid
--------------------

Dans votre controller, deux lignes suffisent :

.. code-block:: php

   public function listEventsAction() {

      $grid_view = $this->get('oxygen_datagrid.loader')->getView('oxygen_passbook_event');
      
      return $grid_view->getGridResponse('OxygenPassbookBundle:Event:list.html.twig');
   }
   
Et dans la vue utilisée par le controller, l'affichage se fait grâce à la fonction twig grid :


.. code-block:: twig

   {% extends oxygen_layout() %}

   {% block mybundle_content %}
   {{ grid(grid) }}
   {% endblock mybundle_content %}

Label des colonnes du DataGrid
------------------------------

Par défaut, le Datagrid sera affiché avec des titres de colonnes correspond au nom des attributs du Datagrid.

Exemple pour traduire :

.. code-block:: yaml

   oxygen_passbook_event:
      dateStart: Début le
      id: '#'
      dateEnd: Fin le
      name: Evènement
      
Le premier niveau est l'identifiant du DataGrid.

Le deuxième niveau est l'attribut de votre source de données.