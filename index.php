<?php

//scripts php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
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
}else if(!isset($id)){
        $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
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
      if ($id != "") {
          $stmt = $conexao->prepare("UPDATE cliente SET nome=?, cpf=?, dataNasc=?, email=?, logradouro=?, numero=?, bairro=?, cidade=?, uf=?, cep=? WHERE id = ?");
          $stmt->bindParam(11, $id);
      } else {
          $stmt = $conexao->prepare("INSERT INTO cliente (nome, cpf, dataNasc, email, logradouro, numero, bairro, cidade, uf, cep) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      }

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
                $id = null;
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


if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "search") {
  try {
      $stmt = $conexao->prepare("SELECT * FROM cliente WHERE cpf = '$cpf'");

      if ($stmt->execute()) {
          $rs = $stmt->fetch(PDO::FETCH_OBJ);
          $id = $rs->id;
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

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "searchLink") {
  try {
      $stmt = $conexao->prepare("SELECT * FROM cliente WHERE id = ?");
      $stmt->bindParam(1, $id, PDO::PARAM_INT);

      if ($stmt->execute()) {
          $rs = $stmt->fetch(PDO::FETCH_OBJ);
          $id = $rs->id;
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

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    try {
        $stmt = $conexao->prepare("DELETE FROM cliente WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "Registo foi excluído com êxito";
            $id = null;
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

if (isset($_POST["buscaCep"]) ) {
  try {
    $url = "https://viacep.com.br/ws/{$cep}/json/";

    $endereco = json_decode(@file_get_contents($url));
    @$logradouro = $endereco->logradouro;
    @$bairro = $endereco->bairro;
    @$cidade = $endereco->localidade;
    @$uf = $endereco->uf;

  } catch (JsonException $e) {

  }



  //var_dump($endereco);
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
    <div class="container">
      <div class="title">Registro Clientes</div>
      <div class="content">
        <form class="" action="?act=save" method="post" name="form1">
          <div class="user-detail">
            <div class="id">
              <input type="hidden" name="id" <?php
                    if (isset($id) && $id != null || $id != "") {
                        echo "value=\"{$id}\"";
                    }
                    ?> >
            </div>

          <div class="input-box">
            <span class="details">Nome</span>
            <input type="text" name="nome" <?php
              if (isset($nome) && $nome != null || $nome != "") {
                  echo "value=\"{$nome}\"";
              }
              ?> >
          </div>
          <br>
          <div class="input-box">
            <span class="details">CPF</span>
            <input type="text" name="cpf" <?php
              if (isset($cpf) && $cpf != null || $cpf != "") {

                  echo "value=\"{$cpf}\"";
              }
              ?>>
          </div>
          <br>
          <div class="input-box">
            <span class="details">Data de Nascimento</span>
            <input type="date" name="dataNasc" <?php
              if (isset($dataNasc) && $dataNasc != null || $dataNasc != "") {
                  echo "value=\"{$dataNasc}\"";
              }
              ?>>
          </div>
          <br>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="text" name="email" <?php
              if (isset($email) && $email != null || $email != "") {
                  echo "value=\"{$email}\"";
              }
              ?>>
          </div>
          <br>
          <div class="input-box">
            <div class="endereco">
              <span class="details">Endereço</span>
            </div>


            <span class="details">Cep</span>
            <input type="text" name="cep" <?php
              if (isset($cep) && $cep != null || $cep != "") {
                  echo "value=\"{$cep}\"";
              }
              ?>>
          </div>
          <div class="button">
            <input type="submit" name="buscaCep" value="Pesquisar">
          </div>
          <br>
          <div class="input-box">
            <span class="details">Logradouro</span>
            <input type="text" name="logradouro" <?php
              if (isset($logradouro) && $logradouro != null || $logradouro != "") {
                  echo "value=\"{$logradouro}\"";
              }
              ?>>
          </div>
          <br>
          <div class="input-box">
            <span class="details">Número</span>
            <input type="INT" name="numero" style="width: 25px"<?php
              if (isset($numero) && $numero != null || $numero != "") {
                  echo "value=\"{$numero}\"";
              }
              ?>>
          </div>
          <br>
          <div class="input-box">
            <span class="details">Bairro</span>
            <input type="text" name="bairro" <?php
              if (isset($bairro) && $bairro != null || $bairro != "") {
                  echo "value=\"{$bairro}\"";
              }
              ?>>
          </div>
          <br>
          <div class="input-box">
            <span class="details">Cidade</span>
            <input type="text" name="cidade" <?php
              if (isset($cidade) && $cidade != null || $cidade != "") {
                  echo "value=\"{$cidade}\"";
              }
              ?>>
          </div>
          <br>
          <div class="input-box">
            <span class="details">UF</span>
            <input type="text" name="uf" <?php
              if (isset($uf) && $uf != null || $uf != "") {
                  echo "value=\"{$uf}\"";
              }
              ?>>
          </div>
            </div>
          <br>
          <div class="button">
            <input type="submit" name="" value="Registrar">
          </div>
          </form>
          <div class="form2">
            <form class="" action="?act=clear" method="post">
              <div class="button">
                <input type="submit" name="" value="Limpar">
              </div>
            </form>
          </div>

          <br>
          <div class="form3">
            <form class="" action="?act=search" method="post" >
              <div class="user-details">
                <input type="text" name="cpf" value="">
              </div>
              <div class="button">
                <input type="submit" name="" value="Pesquisar cliente">
              </div>
            </form>
          </div>

          </div>
        </div>
          <br>
          <div class="tabela">
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

                  $stmt = $conexao->prepare("SELECT * FROM cliente");

                      if ($stmt->execute()) {
                          while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                             echo "<tr>";
                             echo "<td>".$rs->nome."</td><td>".$rs->cpf."</td><td>"
                                        .$rs->dataNasc."</td><td>".$rs->email."</td><td>"
                                        .$rs->logradouro."</td><td>".$rs->numero."</td><td>"
                                        .$rs->bairro."</td><td>".$rs->cidade."</td><td>"
                                        .$rs->uf."</td><td>".$rs->cep
                                        ."</td><td><center><a href=\"  ?act=searchLink&id=" . $rs->id . " \">[Alterar]</a>"
                                        ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                        ."<a href=\" ?act=del&id=" . $rs->id . " \">[Excluir]</a></center></td>";
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
          </div>
  </body>
</html>
