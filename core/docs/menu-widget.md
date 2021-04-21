# Add menu widget

See commit here - [Commit changes](https://github.com/tonephp/tonephp/commit/fd6b5523f691cb75df51d423d018fd1fe8599474)

## 1. Work with database table

### -- Create table

```sql
CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

### -- Add primary key and set auto increment

```sql
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
```

### -- Insert data

```sql
INSERT INTO `category` (`id`, `parent_id`, `title`) VALUES
(1, 0, '1'),
(2, 0, '2'),
(3, 1, '1.1'),
(4, 2, '2.1');
```
