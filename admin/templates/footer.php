<!-- 2da mitad para el template -->
</section>
</main>
    <footer>
        <!-- place footer here -->
         <!-- <p> <....... Footer .......></p> -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <!-- Funcionalidad para el data table -->
     <script>
        $(document).ready( function(){
            // llamado para mostrar el filtrado y el paginador
            //Todos los elementos "table" le pondremos Data...
            $('table').DataTable({
                "pageLength":5, //# de elementos en la pagina
                lengthMenu:[  //opciones menu, paginacion
                    [3, 10, 25, 50],
                    [3, 10, 25, 50]
                ],
                "language":{ //idioma
                    "url":"https://cdn.datatables.net/plug-ins/1.13.2/i18n/es-MX.json"
                }
            });
        });
     </script>
</body>

</html>