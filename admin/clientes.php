<?php include('header.php'); ?>

<?php
include('../server/connection.php');

$is_filter_applied = false;

if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    // Se o usuário já entrou na página então o número da página fica selecionado
    $page_no = $_GET['page_no'];
} else {
    // Número padrão
    $page_no = 1;
}

// Retorna o número de produtos
$stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM users");
$stmt1->execute();
$stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();

$total_records_per_page = 4; // Alterado para 5 produtos por página
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";
$total_no_of_pages = ceil($total_records / $total_records_per_page);

$stmt2 = $conn->prepare("SELECT * FROM users LIMIT ?, ?");
$stmt2->bind_param("ii", $offset, $total_records_per_page);
$stmt2->execute();
$users = $stmt2->get_result();
?>

<div class="recent-grid">
    <div class="projects">
        <div class="card">
            <div class="card-header">
                <h3>Lista de Clientes</h3>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                    <table width="100%" class="orders-table">
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Nome</td>
                                <td>CPF</td>
                                <td>Email</td>
                                <td>Telefone</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($user = $users->fetch_assoc()) { ?>
                                <tr>
                                    <td><strong><?php echo $user['user_id']; ?></strong></td>
                                    <td><?php echo $user['user_name']; ?></td>
                                    <td><?php echo $user['user_cpf']; ?></td>
                                    <td><?php echo $user['user_email']; ?></td>
                                    <td><?php echo $user['user_phone']; ?></td>
                                    <td><hidden button></button></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>