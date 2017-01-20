<table class="table table-hover">
    <thead>
        <tr>
            <th>Symbol</th>
            <th>Name</th>
            <th>Shares</th>
            <th>Price</th>
            <th>TOTAL</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($positions as $position): ?>
        <tr>
            <td><?= $position["symbol"] ?></td>
            <td><?= $position["name"] ?></td>
            <td><?= $position["shares"] ?></td>
            <td>$<?= $position["price"] ?></td>
            <td>$<?= $position["total"] ?></td>
        </tr>
    <?php endforeach ?>
      <tr class="colored">
      <td colspan="4">CASH</td>
      <td>$<?php echo $cash ?></td>
      </tr>
    </tbody>
</table>