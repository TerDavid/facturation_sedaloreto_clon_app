INSERT INTO `bomba_agua` (`id`, `bomba`, `id_ciudades`, `created_at`, `updated_at`) VALUES
(1, 'bomba 117', 1, '2025-04-26 10:18:25', '2025-05-09 09:47:58'),
(2, 'bomba 1', 2, '2025-04-26 12:31:28', '2025-04-26 12:31:28');


INSERT INTO `reservorio` (`id`, `reservorio`, `id_bomba_agua`, `id_ciudad`, `created_at`, `updated_at`) VALUES
(2, 'Reservorio R-1', 1, 1, '2025-05-09 12:34:54', '2025-05-09 12:34:54'),
(3, 'Reservorio R-2', 1, 1, '2025-05-09 13:01:35', '2025-05-09 13:02:20'),
(4, 'Reservorio R-1', 2, 2, '2025-05-09 13:17:54', '2025-05-09 13:17:54');


INSERT INTO `sector` (`id`, `sector`, `id_reservorio`, `id_bomba_agua`, `id_ciudad`, `created_at`, `updated_at`) VALUES
(1, 'San Juan Buatista', 3, 1, 1, '2025-05-09 13:17:10', '2025-05-09 13:17:10'),
(2, 'Santa Cruz', 4, 2, 2, '2025-05-09 13:19:15', '2025-05-09 13:19:15')


INSERT INTO `manzana` (`id`, `manzana`, `id_sector`, `id_reservorio`, `id_bomba_agua`, `id_ciudad`, `created_at`, `updated_at`) VALUES
(1, 'manzana 1', 2, 4, 2, 2, '2025-05-09 14:44:12', '2025-05-09 14:50:21'),
(2, 'Mz 1', 1, 3, 1, 1, '2025-05-09 14:50:40', '2025-05-09 14:50:40');
