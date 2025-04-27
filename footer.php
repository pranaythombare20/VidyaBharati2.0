

</div> <!-- Closing container div -->

<footer class="footer text-black text-center py-3 mt-5">
    <p style="color:white;">&copy; <?php echo date("Y"); ?> <b>Student Management System | All Rights Reserved.</b></p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
html, body {
    height: 100%; /* Full height */
    margin: 0;
    display: flex;
    flex-direction: column;
  
}

.container {
    flex: 1; /* Push footer to bottom */

}

.footer {
    width: 100%;
    position: relative;
    bottom: 0;
    background: linear-gradient(135deg, #43cea2, #185a9d);
}
.footer:hover{
            background: linear-gradient(135deg, #185a9d, #43cea2);
            transform: scale(1.0);
            box-shadow: 0 6px 15px rgba(67, 206, 162, 0.8);
}
</style>
</body>
</html>
