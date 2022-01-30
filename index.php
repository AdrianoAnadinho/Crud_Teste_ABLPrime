<?php
//inicializando as variaveis
$nome = null;
$cpf = null;
$dataNasc = null;
$email = null;
$logradouro = null;
$numero = null;
$bairro = null;
$cidade = null;
$uf = null;
$cep = null;


//scripts php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
  $cpf = (isset($_POST["cpf"]) && $_POST["cpf"] != null) ? $_POST["cpf"] : "";
  $dataNasc = (isset($_POST["dataNasc"]) && $_POST["dataNasc"] != null) ? $_POST["dataNasc"] : "";
  $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
  $logradouro = (isset($_POST["logradouro"]) && $_POST["logradouro"] != null) ? $_POST["logradouro"] : "";
  $numero = (isset($_POST["numero"]) && $_POST["numero"] != null) ? $_POST["numero"] : "";
  $bairro = (isset($_POST["bairro"]) && $_POST["bairro"] != null) ? $_POST["bairro"] : "";
  $cidade = (isset($_POST["cidade"]) && $_POST["cidade"] != null) ? $_POST["cidade"] : "";
  $uf = (isset($_POST["uf"]) && $_POST["uf"] != null) ? $_POST["uf"] : "";
  $cep = (isset($_POST["cep"]) && $_POST["cep"] != null) ? $_POST["cep"] : "";
}else if(!isset($cpf)){

}


try {
    $conexao = new PDO("mysql:host=localhost; dbname=crudbd", "root", "2374");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8");
    //echo "Tudo certo";
} catch (PDOException $erro) {
    echo "Erro na conexão:" . $erro->getMessage();
}


if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "") {
    try {
        $stmt = $conexao->prepare("INSERT INTO clientes (nome, cpf, dataNasc, email, logradouro, numero, bairro, cidade, uf, cep) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $cpf);
        $stmt->bindParam(3, $dataNasc);
        $stmt->bindParam(4, $email);
        $stmt->bindParam(5, $logradouro);
        $stmt->bindParam(6, $numero);
        $stmt->bindParam(7, $bairro);
        $stmt->bindParam(8, $cidade);
        $stmt->bindParam(9, $uf);
        $stmt->bindParam(10, $cep);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "Dados cadastrados com sucesso!";

                $nome = null;
                $cpf = null;
                $dataNasc = null;
                $email = null;
                $logradouro = null;
                $numero = null;
                $bairro = null;
                $cidade = null;
                $uf = null;
                $cep = null;

            } else {
                echo "Erro ao tentar efetivar cadastro";
            }
        } else {
               throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: " . $erro->getMessage();
    }
}

/*if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    try {
        $stmt = $conexao->prepare("SELECT * FROM contatos WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $rs->id;
            $nome = $rs->nome;
            $email = $rs->email;
            $celular = $rs->celular;
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}*/

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "search") {
  echo "agora sim $cpf";
  try {
      $stmt = $conexao->prepare("SELECT * FROM clientes WHERE cpf = '$cpf'");

      if ($stmt->execute()) {
          $rs = $stmt->fetch(PDO::FETCH_OBJ);
          $nome = $rs->nome;
          $cpf = $rs->cpf;
          $dataNasc = $rs->dataNasc;
          $email = $rs->email;
          $logradouro = $rs->logradouro;
          $numero = $rs->numero;
          $bairro = $rs->bairro;
          $cidade = $rs->cidade;
          $uf = $rs->uf;
          $cep = $rs->cep;
      } else {
          throw new PDOException("Erro: Não foi possível executar a declaração sql");
      }
  } catch (PDOException $erro) {
      echo "Erro: ".$erro->getMessage();
  }
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "clear") {
  $nome = null;
  $cpf = null;
  $dataNasc = null;
  $email = null;
  $logradouro = null;
  $numero = null;
  $bairro = null;
  $cidade = null;
  $uf = null;
  $cep = null;
}




 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Teste ABL CRUD</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
      <div class="criar">
        <form class="" action="?act=save" method="post" name="form1">
          <h1>Registro Clientes</h1>
          <hr>
          Nome:
          <input type="text" name="nome" <?php
            if (isset($nome) && $nome != null || $nome != "") {
                echo "value=\"{$nome}\"";
            }
            ?> >
          <br>
          CPF:
          <input type="text" name="cpf" <?php
            if (isset($cpf) && $cpf != null || $cpf != "") {

                echo "value=\"{$cpf}\"";
            }
            ?>>
          <br>
          Data de nascimento:
          <input type="date" name="dataNasc" <?php
            if (isset($dataNasc) && $dataNasc != null || $dataNasc != "") {
                echo "value=\"{$dataNasc}\"";
            }
            ?>>
          <br>
          E-mail:
          <input type="text" name="email" <?php
            if (isset($email) && $email != null || $email != "") {
                echo "value=\"{$email}\"";
            }
            ?>>
          <br>
          Endereço:
          <br>
          Cep:
          <input type="text" name="cep" <?php
            if (isset($cep) && $cep != null || $cep != "") {
                echo "value=\"{$cep}\"";
            }
            ?>>
          <input type="submit" name="" value="Pesquisar Endereço">
          <br>
          logradouro:
          <input type="text" name="logradouro" <?php
            if (isset($logradouro) && $logradouro != null || $logradouro != "") {
                echo "value=\"{$logradouro}\"";
            }
            ?>>
          Número:
          <input type="INT" name="numero" style="width: 25px"<?php
            if (isset($numero) && $numero != null || $numero != "") {
                echo "value=\"{$numero}\"";
            }
            ?>>
          Bairro:
          <input type="text" name="bairro" <?php
            if (isset($bairro) && $bairro != null || $bairro != "") {
                echo "value=\"{$bairro}\"";
            }
            ?>>
          <br>
          Cidade:
          <input type="text" name="cidade" <?php
            if (isset($cidade) && $cidade != null || $cidade != "") {
                echo "value=\"{$cidade}\"";
            }
            ?>>
          UF:
          <input type="text" name="uf" <?php
            if (isset($uf) && $uf != null || $uf != "") {
                echo "value=\"{$uf}\"";
            }
            ?>>
          <br>
          <br>
          <br>
          <br>
          <table border="1" width="100%">
            <tr>
              <th rowspan="2">Nome</th>
              <th rowspan="2">Cpf</th>
              <th rowspan="2">Data de Nascimento</th>
              <th rowspan="2">E-mail</th>
              <th colspan="6"> Endereço </th>
            </tr>
            <tr>
              <th>Logradouro</th>
              <th>Número</th>
              <th>Bairro</th>
              <th>Cidade</th>
              <th>UF</th>
              <th>Cep</th>
            </tr>

            <?php
            try {

                $stmt = $conexao->prepare("SELECT * FROM clientes");

                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                           echo "<tr>";
                           echo "<td>".$rs->nome."</td><td>".$rs->cpf."</td><td>"
                                      .$rs->dataNasc."</td><td>".$rs->email."</td><td>"
                                      .$rs->logradouro."</td><td>".$rs->numero."</td><td>"
                                      .$rs->bairro."</td><td>".$rs->cidade."</td><td>"
                                      .$rs->uf."</td><td>".$rs->cep
                                      ."</td><td><center><a href=\"\">[Alterar]</a>"
                                      ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                      ."<a href=\"\">[Excluir]</a></center></td>";
                           echo "</tr>";
                         }
                   } else {
                        echo "Erro: Não foi possível recuperar os dados do banco de dados";
                    }
                } catch (PDOException $erro) {
                    echo "Erro: ".$erro->getMessage();
                  }
              ?>
          </table>
          <input type="submit" name="" value="Registrar">

        </form>
        <form class="" action="?act=clear" method="post">
          <input type="submit" name="" value="Limpar">
        </form>
        <form class="" action="?act=search" method="post" id="">
          <input type="text" name="cpf" value="" <?php
            if (isset($cpf) && $cpf != null || $cpf != "") {

                echo "value=\"{$cpf}\"";
            }
            ?>>
          <input type="submit" name="" value="Pesquisar cliente">
        </form>
      </div>
  </body>
</html>
